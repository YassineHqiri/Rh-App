<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Employee::count(),
            'active' => Employee::active()->count(),
            'inactive' => Employee::inactive()->count(),
            'recent_hires' => Employee::where('hire_date', '>=', now()->subDays(30))->count(),
            'departments' => Department::count(),
            'pending_leaves' => LeaveRequest::pending()->count(),
            'total_payroll' => (float) Employee::active()->sum('salary'),
            'avg_salary' => (float) Employee::active()->avg('salary'),
        ];

        $departmentStats = Department::withCount(['employees', 'activeEmployees'])
            ->orderBy('name')
            ->get();

        $driver = DB::connection()->getDriverName();
        $monthExpr = $driver === 'sqlite'
            ? "strftime('%Y-%m', hire_date)"
            : "DATE_FORMAT(hire_date, '%Y-%m')";

        $hiringTrend = Employee::selectRaw("{$monthExpr} as month, COUNT(*) as count")
            ->where('hire_date', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $months->put($month, $hiringTrend->get($month, 0));
        }
        $hiringTrend = $months;

        $expiringContracts = Employee::active()
            ->expiringContracts(90)
            ->orderBy('contract_end_date')
            ->take(10)
            ->get();

        $recentActivity = AuditLog::with('user')
            ->latest('created_at')
            ->take(10)
            ->get();

        $recentEmployees = Employee::with('department')
            ->latest()
            ->take(5)
            ->get();

        $leaveByType = LeaveRequest::where('status', 'approved')
            ->whereYear('start_date', now()->year)
            ->join('leave_types', 'leave_requests.leave_type_id', '=', 'leave_types.id')
            ->selectRaw('leave_types.name, SUM(leave_requests.total_days) as total_days')
            ->groupBy('leave_types.name')
            ->pluck('total_days', 'name');

        return view('dashboard', compact(
            'stats',
            'departmentStats',
            'hiringTrend',
            'expiringContracts',
            'recentActivity',
            'recentEmployees',
            'leaveByType'
        ));
    }
}
