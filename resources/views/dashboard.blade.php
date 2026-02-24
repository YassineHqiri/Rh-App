@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    <p class="mt-1 text-sm text-gray-500">Welcome back, {{ Auth::user()->name }}. Here's an overview of your HR operations.</p>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 mb-8">
    <div class="overflow-hidden rounded-xl bg-white shadow ring-1 ring-gray-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-500">Total</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow ring-1 ring-gray-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-500">Active</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ number_format($stats['active']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow ring-1 ring-gray-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-lg bg-amber-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-500">Inactive</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ number_format($stats['inactive']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow ring-1 ring-gray-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-lg bg-purple-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-500">New (30d)</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ number_format($stats['recent_hires']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow ring-1 ring-gray-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3H21m-3.75 3H21"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-500">Depts</dt>
                        <dd class="text-2xl font-bold text-gray-900">{{ number_format($stats['departments']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow ring-1 ring-gray-200">
        <div class="p-5">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="h-10 w-10 rounded-lg bg-rose-100 flex items-center justify-center">
                        <svg class="h-6 w-6 text-rose-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-500">Pending Leave</dt>
                        <dd class="text-2xl font-bold {{ $stats['pending_leaves'] > 0 ? 'text-amber-600' : 'text-gray-900' }}">{{ number_format($stats['pending_leaves']) }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Payroll Summary --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
    <a href="{{ route('salaries.index') }}" class="overflow-hidden rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-700 shadow hover:shadow-lg transition group">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-indigo-100">Total Payroll</p>
                    <p class="mt-1 text-3xl font-bold text-white">{{ number_format($stats['total_payroll'], 2) }} DH</p>
                    <p class="mt-1 text-xs text-indigo-200">{{ $stats['active'] }} active employees</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition">
                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </a>
    <a href="{{ route('salaries.index') }}" class="overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 shadow hover:shadow-lg transition group">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-100">Average Salary</p>
                    <p class="mt-1 text-3xl font-bold text-white">{{ number_format($stats['avg_salary'], 2) }} DH</p>
                    <p class="mt-1 text-xs text-emerald-200">Click to view full salary analytics</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-white/10 flex items-center justify-center group-hover:bg-white/20 transition">
                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/>
                    </svg>
                </div>
            </div>
        </div>
    </a>
</div>

{{-- Charts Row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    {{-- Hiring Trend --}}
    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200 p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Hiring Trend (Last 12 Months)</h2>
        <canvas id="hiringChart" height="200"></canvas>
    </div>

    {{-- Department Headcount --}}
    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200 p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Employees by Department</h2>
        <canvas id="departmentChart" height="200"></canvas>
    </div>
</div>

{{-- Contract Alerts + Leave Usage --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    {{-- Expiring Contracts --}}
    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900">Contract Renewal Alerts</h2>
                <span class="text-xs text-gray-500">Next 90 days</span>
            </div>
        </div>
        <ul role="list" class="divide-y divide-gray-100">
            @forelse($expiringContracts as $emp)
            <li class="px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <a href="{{ route('employees.show', $emp) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600">
                            {{ e($emp->full_name) }}
                        </a>
                        <p class="text-xs text-gray-500">{{ e($emp->position) }}</p>
                    </div>
                    <div class="text-right">
                        @php $daysLeft = now()->diffInDays($emp->contract_end_date, false); @endphp
                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $daysLeft <= 30 ? 'bg-red-50 text-red-700 ring-1 ring-red-600/20' : ($daysLeft <= 60 ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20' : 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/20') }}">
                            {{ $daysLeft }} {{ Str::plural('day', $daysLeft) }} left
                        </span>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $emp->contract_end_date->format('M d, Y') }}</p>
                    </div>
                </div>
            </li>
            @empty
            <li class="px-6 py-8 text-center text-sm text-gray-500">No contracts expiring in the next 90 days.</li>
            @endforelse
        </ul>
    </div>

    {{-- Leave Usage by Type --}}
    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200 p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Leave Usage by Type ({{ now()->year }})</h2>
        @if($leaveByType->count() > 0)
        <canvas id="leaveChart" height="200"></canvas>
        @else
        <div class="flex items-center justify-center h-48 text-sm text-gray-500">No approved leave data this year.</div>
        @endif
    </div>
</div>

{{-- Recent Employees + Activity --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900">Recent Employees</h2>
                <a href="{{ route('employees.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
            </div>
        </div>
        <ul role="list" class="divide-y divide-gray-100">
            @forelse($recentEmployees as $employee)
            <li class="px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="min-w-0">
                        <a href="{{ route('employees.show', $employee) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600">
                            {{ e($employee->full_name) }}
                        </a>
                        <p class="text-xs text-gray-500">
                            {{ e($employee->position) }}
                            @if($employee->department)
                            — {{ e($employee->department->name) }}
                            @endif
                        </p>
                    </div>
                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $employee->status === 'active' ? 'bg-green-50 text-green-700 ring-1 ring-green-600/20' : 'bg-red-50 text-red-700 ring-1 ring-red-600/20' }}">
                        {{ ucfirst($employee->status) }}
                    </span>
                </div>
            </li>
            @empty
            <li class="px-6 py-8 text-center text-sm text-gray-500">No employees found.</li>
            @endforelse
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900">Recent Activity</h2>
                @if(Auth::user()->isAdmin())
                <a href="{{ route('audit.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                @endif
            </div>
        </div>
        <ul role="list" class="divide-y divide-gray-100">
            @forelse($recentActivity as $log)
            <li class="px-6 py-3">
                <div class="flex items-center gap-x-3">
                    @switch($log->action)
                        @case('created')
                            <span class="h-2 w-2 rounded-full bg-green-500"></span>
                            @break
                        @case('updated')
                            <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                            @break
                        @case('deleted')
                            <span class="h-2 w-2 rounded-full bg-red-500"></span>
                            @break
                        @case('login_success')
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            @break
                        @case('login_failed')
                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                            @break
                        @default
                            <span class="h-2 w-2 rounded-full bg-gray-400"></span>
                    @endswitch
                    <div class="min-w-0 flex-1">
                        <p class="text-sm text-gray-900">
                            <span class="font-medium">{{ e($log->user->name ?? 'System') }}</span>
                            <span class="text-gray-500">{{ $log->action }}</span>
                            <span class="text-gray-500">{{ class_basename($log->model_type ?? '') }}</span>
                        </p>
                        <p class="text-xs text-gray-400">{{ $log->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </li>
            @empty
            <li class="px-6 py-8 text-center text-sm text-gray-500">No activity yet.</li>
            @endforelse
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartColors = ['#6366f1', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6'];

    // Hiring Trend
    new Chart(document.getElementById('hiringChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($hiringTrend->keys()->map(fn($m) => \Carbon\Carbon::parse($m . '-01')->format('M Y'))->values()) !!},
            datasets: [{
                label: 'New Hires',
                data: {!! json_encode($hiringTrend->values()) !!},
                backgroundColor: '#6366f1',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // Department Headcount
    const deptLabels = {!! json_encode($departmentStats->pluck('name')->values()) !!};
    const deptData = {!! json_encode($departmentStats->pluck('employees_count')->values()) !!};

    if (deptLabels.length > 0) {
        new Chart(document.getElementById('departmentChart'), {
            type: 'doughnut',
            data: {
                labels: deptLabels,
                datasets: [{
                    data: deptData,
                    backgroundColor: chartColors.slice(0, deptLabels.length),
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'right', labels: { boxWidth: 12, padding: 16 } }
                }
            }
        });
    }

    // Leave Usage
    const leaveEl = document.getElementById('leaveChart');
    if (leaveEl) {
        const leaveLabels = {!! json_encode($leaveByType->keys()->values()) !!};
        const leaveData = {!! json_encode($leaveByType->values()) !!};

        new Chart(leaveEl, {
            type: 'bar',
            data: {
                labels: leaveLabels,
                datasets: [{
                    label: 'Days Used',
                    data: leaveData,
                    backgroundColor: chartColors.slice(0, leaveLabels.length),
                    borderRadius: 6,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, ticks: { stepSize: 1 } },
                    y: { grid: { display: false } }
                }
            }
        });
    }
});
</script>
@endsection
