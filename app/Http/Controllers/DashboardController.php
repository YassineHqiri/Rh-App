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
        // Get filter parameters from request
        $departmentFilter = request('department');
        $statusFilter = request('status');
        $hireDateFilter = request('hire_date_from');
        $hireDateTo = request('hire_date_to');

        // Build base query with filters
        $baseQuery = Employee::query();

        if ($departmentFilter) {
            $baseQuery->where('department_id', $departmentFilter);
        }

        if ($statusFilter) {
            if ($statusFilter === 'active') {
                $baseQuery->active();
            } elseif ($statusFilter === 'inactive') {
                $baseQuery->inactive();
            }
        }

        if ($hireDateFilter) {
            $baseQuery->where('hire_date', '>=', $hireDateFilter);
        }

        if ($hireDateTo) {
            $baseQuery->where('hire_date', '<=', $hireDateTo);
        }

        // Calculate statistics based on filtered query
        $stats = [
            'total' => (clone $baseQuery)->count(),
            'active' => (clone $baseQuery)->active()->count(),
            'inactive' => (clone $baseQuery)->inactive()->count(),
            'recent_hires' => (clone $baseQuery)->where('hire_date', '>=', now()->subDays(30))->count(),
            'departments' => Department::count(),
            'pending_leaves' => LeaveRequest::pending()->count(),
            'total_payroll' => (float) (clone $baseQuery)->active()->sum('salary'),
            'avg_salary' => (float) (clone $baseQuery)->active()->avg('salary'),
        ];

        // Department stats filtered
        $departmentStats = Department::withCount('employees')
            ->withCount(['activeEmployees' => function ($query) use ($hireDateFilter, $hireDateTo, $statusFilter) {
                if ($statusFilter !== 'inactive') {
                    $query->active();
                }
                if ($hireDateFilter) {
                    $query->where('hire_date', '>=', $hireDateFilter);
                }
                if ($hireDateTo) {
                    $query->where('hire_date', '<=', $hireDateTo);
                }
            }])
            ->orderBy('name')
            ->get();

        // Hiring trend with filters
        $driver = DB::connection()->getDriverName();
        $monthExpr = $driver === 'sqlite'
            ? "strftime('%Y-%m', hire_date)"
            : "DATE_FORMAT(hire_date, '%Y-%m')";

        $hiringTrendQuery = Employee::selectRaw("{$monthExpr} as month, COUNT(*) as count")
            ->where('hire_date', '>=', now()->subMonths(12));

        if ($departmentFilter) {
            $hiringTrendQuery->where('department_id', $departmentFilter);
        }
        if ($statusFilter) {
            if ($statusFilter === 'active') {
                $hiringTrendQuery->active();
            } elseif ($statusFilter === 'inactive') {
                $hiringTrendQuery->inactive();
            }
        }
        if ($hireDateFilter) {
            $hiringTrendQuery->where('hire_date', '>=', $hireDateFilter);
        }
        if ($hireDateTo) {
            $hiringTrendQuery->where('hire_date', '<=', $hireDateTo);
        }

        $hiringTrend = $hiringTrendQuery
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $months->put($month, $hiringTrend->get($month, 0));
        }
        $hiringTrend = $months;

        // Expiring contracts with filters
        $expiringContractsQuery = Employee::active()
            ->expiringContracts(90);

        if ($departmentFilter) {
            $expiringContractsQuery->where('department_id', $departmentFilter);
        }
        if ($hireDateFilter) {
            $expiringContractsQuery->where('hire_date', '>=', $hireDateFilter);
        }
        if ($hireDateTo) {
            $expiringContractsQuery->where('hire_date', '<=', $hireDateTo);
        }

        $expiringContracts = $expiringContractsQuery
            ->orderBy('contract_end_date')
            ->take(10)
            ->get();

        // Recent activity
        $recentActivity = AuditLog::with('user')
            ->latest('created_at')
            ->take(10)
            ->get();

        // Recent employees with filters
        $recentEmployeesQuery = Employee::with('department');

        if ($departmentFilter) {
            $recentEmployeesQuery->where('department_id', $departmentFilter);
        }
        if ($statusFilter) {
            if ($statusFilter === 'active') {
                $recentEmployeesQuery->active();
            } elseif ($statusFilter === 'inactive') {
                $recentEmployeesQuery->inactive();
            }
        }
        if ($hireDateFilter) {
            $recentEmployeesQuery->where('hire_date', '>=', $hireDateFilter);
        }
        if ($hireDateTo) {
            $recentEmployeesQuery->where('hire_date', '<=', $hireDateTo);
        }

        $recentEmployees = $recentEmployeesQuery->latest()->take(5)->get();

        // Leave by type
        $leaveByType = LeaveRequest::where('status', 'approved')
            ->whereYear('start_date', now()->year)
            ->join('leave_types', 'leave_requests.leave_type_id', '=', 'leave_types.id')
            ->selectRaw('leave_types.name, SUM(leave_requests.total_days) as total_days')
            ->groupBy('leave_types.name')
            ->pluck('total_days', 'name');

        // Get all departments for filter dropdown
        $departments = Department::orderBy('name')->get();

        return view('dashboard', compact(
            'stats',
            'departmentStats',
            'hiringTrend',
            'expiringContracts',
            'recentActivity',
            'recentEmployees',
            'leaveByType',
            'departments',
            'departmentFilter',
            'statusFilter',
            'hireDateFilter',
            'hireDateTo'
        ));
    }
}
