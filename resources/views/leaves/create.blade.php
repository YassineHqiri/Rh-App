@extends('layouts.app')

@section('title', 'New Leave Request')

@section('content')
<div class="mb-8">
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('leaves.index') }}" class="hover:text-gray-700">Leave Management</a></li>
            <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></li>
            <li class="font-medium text-gray-900">New Request</li>
        </ol>
    </nav>
    <h1 class="text-2xl font-bold text-gray-900">New Leave Request</h1>
    <p class="mt-1 text-sm text-gray-500">Submit a leave request for an employee.</p>
</div>

<div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
    <form method="POST" action="{{ route('leaves.store') }}">
        @csrf
        <div class="p-6 sm:p-8">
            <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-2">
                <div>
                    <label for="employee_id" class="block text-sm font-medium leading-6 text-gray-900">Employee <span class="text-red-500">*</span></label>
                    <div class="mt-2">
                        <select name="employee_id" id="employee_id" required
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('employee_id') ring-red-300 @enderror">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ e($employee->full_name) }}
                            </option>
                            @endforeach
                        </select>
                        @error('employee_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="leave_type_id" class="block text-sm font-medium leading-6 text-gray-900">Leave Type <span class="text-red-500">*</span></label>
                    <div class="mt-2">
                        <select name="leave_type_id" id="leave_type_id" required
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('leave_type_id') ring-red-300 @enderror">
                            <option value="">Select Type</option>
                            @foreach($leaveTypes as $type)
                            <option value="{{ $type->id }}" {{ old('leave_type_id') == $type->id ? 'selected' : '' }}>
                                {{ e($type->name) }} ({{ $type->default_days_per_year }} days/year)
                            </option>
                            @endforeach
                        </select>
                        @error('leave_type_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium leading-6 text-gray-900">Start Date <span class="text-red-500">*</span></label>
                    <div class="mt-2">
                        <input type="date" name="start_date" id="start_date" required
                               value="{{ old('start_date') }}"
                               class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('start_date') ring-red-300 @enderror">
                        @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium leading-6 text-gray-900">End Date <span class="text-red-500">*</span></label>
                    <div class="mt-2">
                        <input type="date" name="end_date" id="end_date" required
                               value="{{ old('end_date') }}"
                               class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('end_date') ring-red-300 @enderror">
                        @error('end_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="reason" class="block text-sm font-medium leading-6 text-gray-900">Reason</label>
                    <div class="mt-2">
                        <textarea name="reason" id="reason" rows="3" maxlength="1000"
                                  class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm @error('reason') ring-red-300 @enderror">{{ old('reason') }}</textarea>
                        @error('reason')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end gap-x-3 border-t border-gray-200 px-6 py-4 sm:px-8">
            <a href="{{ route('leaves.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">Cancel</a>
            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                Submit Request
            </button>
        </div>
    </form>
</div>
@endsection
