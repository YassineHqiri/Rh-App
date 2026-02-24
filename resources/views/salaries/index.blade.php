@extends('layouts.app')

@section('title', 'Salary Statistics')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Salary Statistics</h1>
    <p class="mt-1 text-sm text-gray-500">Payroll overview and salary analytics for active employees.</p>
</div>

{{-- Overview Cards --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 mb-8">
    <div class="overflow-hidden rounded-xl bg-white shadow ring-1 ring-gray-200">
        <div class="p-5">
            <dt class="truncate text-sm font-medium text-gray-500">Total Payroll</dt>
            <dd class="mt-1 text-xl font-bold text-gray-900">{{ number_format($overview['total_payroll'], 2) }} DH</dd>
            <p class="mt-0.5 text-xs text-gray-400">{{ $overview['total_employees'] }} active employees</p>
        </div>
    </div>
    <div class="overflow-hidden rounded-xl bg-white shadow ring-1 ring-gray-200">
        <div class="p-5">
            <dt class="truncate text-sm font-medium text-gray-500">Average Salary</dt>
            <dd class="mt-1 text-xl font-bold text-green-600">{{ number_format($overview['average_salary'], 2) }} DH</dd>
        </div>
    </div>
    <div class="overflow-hidden rounded-xl bg-white shadow ring-1 ring-gray-200">
        <div class="p-5">
            <dt class="truncate text-sm font-medium text-gray-500">Median Salary</dt>
            <dd class="mt-1 text-xl font-bold text-blue-600">{{ number_format($overview['median_salary'], 2) }} DH</dd>
        </div>
    </div>
    <div class="overflow-hidden rounded-xl bg-white shadow ring-1 ring-gray-200">
        <div class="p-5">
            <dt class="truncate text-sm font-medium text-gray-500">Highest Salary</dt>
            <dd class="mt-1 text-xl font-bold text-purple-600">{{ number_format($overview['max_salary'], 2) }} DH</dd>
        </div>
    </div>
    <div class="overflow-hidden rounded-xl bg-white shadow ring-1 ring-gray-200">
        <div class="p-5">
            <dt class="truncate text-sm font-medium text-gray-500">Lowest Salary</dt>
            <dd class="mt-1 text-xl font-bold text-amber-600">{{ number_format($overview['min_salary'], 2) }} DH</dd>
        </div>
    </div>
    <div class="overflow-hidden rounded-xl bg-white shadow ring-1 ring-gray-200">
        <div class="p-5">
            <dt class="truncate text-sm font-medium text-gray-500">Salary Range</dt>
            <dd class="mt-1 text-xl font-bold text-gray-900">{{ number_format($overview['max_salary'] - $overview['min_salary'], 2) }} DH</dd>
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200 p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Average Salary by Department</h2>
        <canvas id="deptSalaryChart" height="250"></canvas>
    </div>
    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200 p-6">
        <h2 class="text-base font-semibold text-gray-900 mb-4">Salary Distribution</h2>
        <canvas id="distributionChart" height="250"></canvas>
    </div>
</div>

{{-- Department Breakdown Table --}}
<div class="bg-white rounded-xl shadow ring-1 ring-gray-200 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-base font-semibold text-gray-900">Department Salary Breakdown</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Department</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Employees</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Total Payroll</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Average</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Min</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Max</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Spread</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($byDepartment as $dept)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('departments.show', $dept->id) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600">{{ e($dept->name) }}</a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $dept->employee_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-right">{{ number_format($dept->total_salary, 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($dept->avg_salary, 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($dept->min_salary, 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($dept->max_salary, 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        @php $spread = $dept->max_salary - $dept->min_salary; @endphp
                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $spread > 10000 ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20' : 'bg-green-50 text-green-700 ring-1 ring-green-600/20' }}">
                            {{ number_format($spread, 0) }} DH
                        </span>
                    </td>
                </tr>
                @endforeach
                @if($unassigned && $unassigned->employee_count > 0)
                <tr class="hover:bg-gray-50 bg-gray-50/50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 italic">Unassigned</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ $unassigned->employee_count }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 text-right">{{ number_format($unassigned->total_salary, 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($unassigned->avg_salary, 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($unassigned->min_salary, 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($unassigned->max_salary, 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium bg-gray-100 text-gray-600">
                            {{ number_format($unassigned->max_salary - $unassigned->min_salary, 0) }} DH
                        </span>
                    </td>
                </tr>
                @endif
            </tbody>
            <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Total</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">{{ $overview['total_employees'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">{{ number_format($overview['total_payroll'], 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">{{ number_format($overview['average_salary'], 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-500 text-right">{{ number_format($overview['min_salary'], 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-500 text-right">{{ number_format($overview['max_salary'], 2) }} DH</td>
                    <td class="px-6 py-4"></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

{{-- Top & Bottom Earners --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-base font-semibold text-gray-900">Top 5 Earners</h2>
        </div>
        <ul role="list" class="divide-y divide-gray-100">
            @foreach($topEarners as $i => $emp)
            <li class="px-6 py-3 flex items-center justify-between hover:bg-gray-50">
                <div class="flex items-center gap-x-3">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-bold {{ $i < 3 ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $i + 1 }}
                    </span>
                    <div>
                        <a href="{{ route('employees.show', $emp) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600">{{ e($emp->full_name) }}</a>
                        <p class="text-xs text-gray-500">{{ e($emp->position) }}{{ $emp->department ? ' — ' . e($emp->department->name) : '' }}</p>
                    </div>
                </div>
                <span class="text-sm font-semibold text-gray-900">{{ number_format($emp->salary, 2) }} DH</span>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-base font-semibold text-gray-900">Bottom 5 Earners</h2>
        </div>
        <ul role="list" class="divide-y divide-gray-100">
            @foreach($bottomEarners as $i => $emp)
            <li class="px-6 py-3 flex items-center justify-between hover:bg-gray-50">
                <div class="flex items-center gap-x-3">
                    <span class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-bold bg-gray-100 text-gray-600">
                        {{ $i + 1 }}
                    </span>
                    <div>
                        <a href="{{ route('employees.show', $emp) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600">{{ e($emp->full_name) }}</a>
                        <p class="text-xs text-gray-500">{{ e($emp->position) }}{{ $emp->department ? ' — ' . e($emp->department->name) : '' }}</p>
                    </div>
                </div>
                <span class="text-sm font-semibold text-gray-900">{{ number_format($emp->salary, 2) }} DH</span>
            </li>
            @endforeach
        </ul>
    </div>
</div>

{{-- Recent Salary Changes --}}
<div class="bg-white rounded-xl shadow ring-1 ring-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-base font-semibold text-gray-900">Recent Salary Changes</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Employee</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Previous</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">New</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Change</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentChanges as $change)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($change->employee)
                        <a href="{{ route('employees.show', $change->employee) }}" class="text-sm font-medium text-gray-900 hover:text-indigo-600">{{ e($change->employee->full_name) }}</a>
                        @else
                        <span class="text-sm text-gray-400">Deleted employee</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($change->old_salary, 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">{{ number_format($change->new_salary, 2) }} DH</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        @php $pct = $change->old_salary > 0 ? ($change->change / $change->old_salary) * 100 : 0; @endphp
                        <span class="inline-flex items-center gap-x-1 text-sm font-medium {{ $change->change >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            @if($change->change >= 0)
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5"/></svg>
                            @else
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                            @endif
                            {{ number_format(abs($change->change), 2) }} DH
                            <span class="text-xs text-gray-400">({{ ($change->change >= 0 ? '+' : '') }}{{ number_format($pct, 1) }}%)</span>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ $change->date->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No salary changes recorded yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const colors = ['#6366f1', '#22c55e', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899', '#14b8a6', '#f97316', '#64748b'];

    const deptLabels = {!! json_encode($byDepartment->pluck('name')->values()) !!};
    const deptAvg = {!! json_encode($byDepartment->pluck('avg_salary')->map(fn($v) => round((float)$v, 2))->values()) !!};

    if (deptLabels.length > 0) {
        new Chart(document.getElementById('deptSalaryChart'), {
            type: 'bar',
            data: {
                labels: deptLabels,
                datasets: [{
                    label: 'Avg Salary',
                    data: deptAvg,
                    backgroundColor: colors.slice(0, deptLabels.length),
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: v => v.toLocaleString() + ' DH' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    const distLabels = {!! json_encode(collect($ranges)->pluck('label')->values()) !!};
    const distData = {!! json_encode(collect($ranges)->pluck('count')->values()) !!};

    new Chart(document.getElementById('distributionChart'), {
        type: 'bar',
        data: {
            labels: distLabels,
            datasets: [{
                label: 'Employees',
                data: distData,
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
});
</script>
@endsection
