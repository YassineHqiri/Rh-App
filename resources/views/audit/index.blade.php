@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Audit Logs</h1>
    <p class="mt-1 text-sm text-gray-500">Complete history of all system actions and changes.</p>
</div>

{{-- Filters --}}
<div class="bg-white rounded-xl shadow ring-1 ring-gray-200 mb-6">
    <div class="p-4">
        <form method="GET" action="{{ route('audit.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="sm:w-48">
                <select name="action"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                    <option value="">All Actions</option>
                    <option value="created" {{ request('action') === 'created' ? 'selected' : '' }}>Created</option>
                    <option value="updated" {{ request('action') === 'updated' ? 'selected' : '' }}>Updated</option>
                    <option value="deleted" {{ request('action') === 'deleted' ? 'selected' : '' }}>Deleted</option>
                    <option value="login_success" {{ request('action') === 'login_success' ? 'selected' : '' }}>Login Success</option>
                    <option value="login_failed" {{ request('action') === 'login_failed' ? 'selected' : '' }}>Login Failed</option>
                    <option value="logout" {{ request('action') === 'logout' ? 'selected' : '' }}>Logout</option>
                </select>
            </div>
            <div>
                <input type="date" name="date_from" value="{{ request('date_from') }}"
                       class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                       placeholder="From">
            </div>
            <div>
                <input type="date" name="date_to" value="{{ request('date_to') }}"
                       class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                       placeholder="To">
            </div>
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 transition">
                Filter
            </button>
            @if(request()->anyFilled(['action', 'date_from', 'date_to']))
            <a href="{{ route('audit.index') }}" class="inline-flex items-center justify-center rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-200 transition">
                Clear
            </a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="bg-white rounded-xl shadow ring-1 ring-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Timestamp</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Target</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IP Address</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Details</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @forelse($logs as $log)
                <tr class="hover:bg-gray-50">
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ $log->created_at->format('M d, Y H:i:s') }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">{{ e($log->user->name ?? 'Guest') }}</td>
                    <td class="whitespace-nowrap px-6 py-4">
                        @php
                            $actionColors = [
                                'created' => 'bg-green-50 text-green-700 ring-green-600/20',
                                'updated' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                'deleted' => 'bg-red-50 text-red-700 ring-red-600/20',
                                'login_success' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                'login_failed' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                'logout' => 'bg-gray-50 text-gray-700 ring-gray-600/20',
                            ];
                            $color = $actionColors[$log->action] ?? 'bg-gray-50 text-gray-700 ring-gray-600/20';
                        @endphp
                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ring-1 {{ $color }}">
                            {{ str_replace('_', ' ', ucfirst($log->action)) }}
                        </span>
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                        {{ class_basename($log->model_type ?? '') }}
                        @if($log->model_id) #{{ $log->model_id }} @endif
                    </td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">{{ e($log->ip_address) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500" x-data="{ open: false }">
                        @if($log->old_values || $log->new_values)
                        <button @click="open = !open" class="text-indigo-600 hover:text-indigo-500 text-xs font-medium">
                            <span x-text="open ? 'Hide' : 'Show'">Show</span> details
                        </button>
                        <div x-show="open" x-cloak class="mt-2 text-xs max-w-xs">
                            @if($log->old_values)
                            <p class="font-medium text-gray-700 mb-1">Old values:</p>
                            <pre class="bg-red-50 p-2 rounded text-red-800 overflow-auto max-h-32">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                            @endif
                            @if($log->new_values)
                            <p class="font-medium text-gray-700 mt-2 mb-1">New values:</p>
                            <pre class="bg-green-50 p-2 rounded text-green-800 overflow-auto max-h-32">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                            @endif
                        </div>
                        @else
                        <span class="text-gray-400">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">No audit logs found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
    <div class="border-t border-gray-200 px-6 py-4">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
