@extends('layouts.app')

@section('title', 'Leave Request #' . $leave->id)

@section('content')
<div class="mb-8">
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('leaves.index') }}" class="hover:text-gray-700">Leave Management</a></li>
            <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></li>
            <li class="font-medium text-gray-900">Request #{{ $leave->id }}</li>
        </ol>
    </nav>
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Leave Request #{{ $leave->id }}</h1>
            <p class="mt-1 text-sm text-gray-500">Submitted {{ $leave->created_at->format('M d, Y') }}</p>
        </div>
        <span class="inline-flex items-center rounded-full px-3 py-1.5 text-sm font-medium {{ $leave->status_badge_class }}">
            {{ ucfirst($leave->status) }}
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        {{-- Request Details --}}
        <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900">Request Details</h2>
            </div>
            <dl class="divide-y divide-gray-100">
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Employee</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <a href="{{ route('employees.show', $leave->employee) }}" class="text-indigo-600 hover:text-indigo-500">{{ e($leave->employee->full_name) }}</a>
                        @if($leave->employee->department)
                        <span class="text-gray-500">— {{ e($leave->employee->department->name) }}</span>
                        @endif
                    </dd>
                </div>
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Leave Type</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{ e($leave->leaveType->name) }}</dd>
                </div>
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Period</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ $leave->start_date->format('F j, Y') }} — {{ $leave->end_date->format('F j, Y') }}
                    </dd>
                </div>
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Total Days</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 sm:col-span-2 sm:mt-0">{{ $leave->total_days }} {{ Str::plural('day', $leave->total_days) }}</dd>
                </div>
                @if($leave->reason)
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Reason</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 whitespace-pre-line">{{ e($leave->reason) }}</dd>
                </div>
                @endif
                @if($leave->reviewer)
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Reviewed By</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        {{ e($leave->reviewer->name) }} on {{ $leave->reviewed_at->format('M d, Y H:i') }}
                    </dd>
                </div>
                @endif
                @if($leave->review_note)
                <div class="px-6 py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Review Note</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 whitespace-pre-line">{{ e($leave->review_note) }}</dd>
                </div>
                @endif
            </dl>
        </div>

        {{-- Approve/Reject Actions --}}
        @if($leave->status === 'pending' && auth()->user()->isAdmin())
        <div class="bg-white rounded-xl shadow ring-1 ring-gray-200 p-6">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Review This Request</h2>
            <div class="mb-4">
                <label for="review_note" class="block text-sm font-medium text-gray-700 mb-1">Review Note (optional)</label>
                <textarea id="review_note" name="review_note_input" rows="2" maxlength="500"
                          class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm"
                          x-data x-ref="reviewNote"></textarea>
            </div>
            <div class="flex gap-x-3" x-data>
                <form method="POST" action="{{ route('leaves.approve', $leave) }}"
                      onsubmit="this.querySelector('[name=review_note]').value = document.getElementById('review_note').value">
                    @csrf
                    <input type="hidden" name="review_note" value="">
                    <button type="submit"
                            class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-500 transition">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Approve
                    </button>
                </form>
                <form method="POST" action="{{ route('leaves.reject', $leave) }}"
                      onsubmit="this.querySelector('[name=review_note]').value = document.getElementById('review_note').value">
                    @csrf
                    <input type="hidden" name="review_note" value="">
                    <button type="submit"
                            class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-500 transition">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        Reject
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    {{-- Leave Balance Sidebar --}}
    <div>
        <div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-base font-semibold text-gray-900">Leave Usage ({{ now()->year }})</h2>
            </div>
            <div class="p-6">
                @forelse($employeeLeaveStats as $stat)
                <div class="mb-4 last:mb-0">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">{{ e($stat->leaveType->name) }}</span>
                        <span class="text-sm text-gray-500">{{ $stat->total_used }} / {{ $stat->leaveType->default_days_per_year }} days</span>
                    </div>
                    @php
                        $percentage = $stat->leaveType->default_days_per_year > 0
                            ? min(100, ($stat->total_used / $stat->leaveType->default_days_per_year) * 100)
                            : 0;
                    @endphp
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="h-2 rounded-full {{ $percentage > 80 ? 'bg-red-500' : ($percentage > 50 ? 'bg-amber-500' : 'bg-green-500') }}"
                             style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500">No approved leave this year.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
