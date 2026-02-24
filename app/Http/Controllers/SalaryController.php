<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    public function index()
    {
        $activeEmployees = Employee::active();

        $overview = [
            'total_payroll' => (float) Employee::active()->sum('salary'),
            'average_salary' => (float) Employee::active()->avg('salary'),
            'median_salary' => $this->getMedianSalary(),
            'min_salary' => (float) Employee::active()->min('salary'),
            'max_salary' => (float) Employee::active()->max('salary'),
            'total_employees' => Employee::active()->count(),
        ];

        $byDepartment = Department::select('departments.id', 'departments.name')
            ->join('employees', 'departments.id', '=', 'employees.department_id')
            ->where('employees.status', 'active')
            ->whereNull('employees.deleted_at')
            ->groupBy('departments.id', 'departments.name')
            ->selectRaw('COUNT(employees.id) as employee_count')
            ->selectRaw('SUM(employees.salary) as total_salary')
            ->selectRaw('AVG(employees.salary) as avg_salary')
            ->selectRaw('MIN(employees.salary) as min_salary')
            ->selectRaw('MAX(employees.salary) as max_salary')
            ->orderBy('departments.name')
            ->get();

        $unassigned = Employee::active()
            ->whereNull('department_id')
            ->selectRaw('COUNT(*) as employee_count, SUM(salary) as total_salary, AVG(salary) as avg_salary, MIN(salary) as min_salary, MAX(salary) as max_salary')
            ->first();

        $ranges = $this->getSalaryDistribution();

        $topEarners = Employee::active()
            ->with('department')
            ->orderByDesc('salary')
            ->take(5)
            ->get();

        $bottomEarners = Employee::active()
            ->with('department')
            ->orderBy('salary')
            ->take(5)
            ->get();

        $recentChanges = DB::table('audit_logs')
            ->where('model_type', 'App\\Models\\Employee')
            ->where('action', 'updated')
            ->whereNotNull('old_values')
            ->whereNotNull('new_values')
            ->latest('created_at')
            ->take(50)
            ->get()
            ->filter(function ($log) {
                $old = json_decode($log->old_values, true) ?? [];
                $new = json_decode($log->new_values, true) ?? [];
                return isset($old['salary']) && isset($new['salary']) && $old['salary'] != $new['salary'];
            })
            ->take(10)
            ->map(function ($log) {
                $old = json_decode($log->old_values, true);
                $new = json_decode($log->new_values, true);
                $employee = Employee::withTrashed()->find($log->model_id);
                return (object) [
                    'employee' => $employee,
                    'old_salary' => $old['salary'] ?? 0,
                    'new_salary' => $new['salary'] ?? 0,
                    'change' => ($new['salary'] ?? 0) - ($old['salary'] ?? 0),
                    'date' => \Carbon\Carbon::parse($log->created_at),
                ];
            });

        return view('salaries.index', compact(
            'overview',
            'byDepartment',
            'unassigned',
            'ranges',
            'topEarners',
            'bottomEarners',
            'recentChanges'
        ));
    }

    private function getMedianSalary(): float
    {
        $salaries = Employee::active()->orderBy('salary')->pluck('salary');
        $count = $salaries->count();

        if ($count === 0) return 0;

        $middle = (int) floor($count / 2);

        if ($count % 2 === 0) {
            return ($salaries[$middle - 1] + $salaries[$middle]) / 2;
        }

        return (float) $salaries[$middle];
    }

    private function getSalaryDistribution(): array
    {
        $brackets = [
            ['label' => 'Under 3K DH', 'min' => 0, 'max' => 3000],
            ['label' => '3K - 5K DH', 'min' => 3000, 'max' => 5000],
            ['label' => '5K - 8K DH', 'min' => 5000, 'max' => 8000],
            ['label' => '8K - 12K DH', 'min' => 8000, 'max' => 12000],
            ['label' => '12K - 20K DH', 'min' => 12000, 'max' => 20000],
            ['label' => '20K - 40K DH', 'min' => 20000, 'max' => 40000],
            ['label' => 'Over 40K DH', 'min' => 40000, 'max' => 99999999999],
        ];

        $result = [];
        foreach ($brackets as $bracket) {
            $count = Employee::active()
                ->where('salary', '>=', $bracket['min'])
                ->where('salary', '<', $bracket['max'])
                ->count();
            $result[] = [
                'label' => $bracket['label'],
                'count' => $count,
            ];
        }

        return $result;
    }
}
