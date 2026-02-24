@extends('layouts.app')

@section('title', 'Departments')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Departments</h1>
        <p class="mt-1 text-sm text-gray-500">Manage organizational departments and their assignments.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('departments.create') }}"
           class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
            <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"/>
            </svg>
            Add Department
        </a>
    </div>
</div>

{{-- Search --}}
<div class="bg-white rounded-xl shadow ring-1 ring-gray-200 mb-6">
    <div class="p-4">
        <form method="GET" action="{{ route('departments.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search departments..."
                       class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
            </div>
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 transition">
                Search
            </button>
            @if(request()->anyFilled(['search']))
            <a href="{{ route('departments.index') }}" class="inline-flex items-center justify-center rounded-lg bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-200 transition">
                Clear
            </a>
            @endif
        </form>
    </div>
</div>

{{-- Grid --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
    @forelse($departments as $department)
    <div class="bg-white rounded-xl shadow ring-1 ring-gray-200 overflow-hidden hover:shadow-md transition">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3H21m-3.75 3H21"/>
                    </svg>
                </div>
                <div class="flex gap-x-2">
                    <a href="{{ route('departments.edit', $department) }}" class="text-gray-400 hover:text-blue-600" title="Edit">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"/>
                        </svg>
                    </a>
                </div>
            </div>
            <a href="{{ route('departments.show', $department) }}" class="block">
                <h3 class="text-lg font-semibold text-gray-900 hover:text-indigo-600">{{ e($department->name) }}</h3>
                @if($department->description)
                <p class="mt-1 text-sm text-gray-500 line-clamp-2">{{ e($department->description) }}</p>
                @endif
            </a>
            <div class="mt-4 flex items-center gap-x-4 text-sm text-gray-500">
                <div class="flex items-center gap-x-1">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                    </svg>
                    <span>{{ $department->employees_count }} {{ Str::plural('employee', $department->employees_count) }}</span>
                </div>
                <div class="flex items-center gap-x-1">
                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-green-50 text-green-700 ring-1 ring-green-600/20">
                        {{ $department->active_employees_count }} active
                    </span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="sm:col-span-2 lg:col-span-3 bg-white rounded-xl shadow ring-1 ring-gray-200 px-6 py-12 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3H21m-3.75 3H21"/>
        </svg>
        <h3 class="mt-2 text-sm font-semibold text-gray-900">No departments found</h3>
        <p class="mt-1 text-sm text-gray-500">Get started by creating a department.</p>
        <div class="mt-4">
            <a href="{{ route('departments.create') }}" class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                Add Department
            </a>
        </div>
    </div>
    @endforelse
</div>

@if($departments->hasPages())
<div class="mt-6">
    {{ $departments->links() }}
</div>
@endif
@endsection
