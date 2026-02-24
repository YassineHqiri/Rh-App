@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')
<div class="mb-8">
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('departments.index') }}" class="hover:text-gray-700">Departments</a></li>
            <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></li>
            <li><a href="{{ route('departments.show', $department) }}" class="hover:text-gray-700">{{ e($department->name) }}</a></li>
            <li><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/></svg></li>
            <li class="font-medium text-gray-900">Edit</li>
        </ol>
    </nav>
    <h1 class="text-2xl font-bold text-gray-900">Edit Department</h1>
    <p class="mt-1 text-sm text-gray-500">Update details for {{ e($department->name) }}.</p>
</div>

<div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
    <form method="POST" action="{{ route('departments.update', $department) }}">
        @csrf
        @method('PUT')
        <div class="p-6 sm:p-8">
            @include('departments._form')
        </div>
        <div class="flex items-center justify-end gap-x-3 border-t border-gray-200 px-6 py-4 sm:px-8">
            <a href="{{ route('departments.show', $department) }}" class="rounded-lg px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">Cancel</a>
            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                Update Department
            </button>
        </div>
    </form>
</div>
@endsection
