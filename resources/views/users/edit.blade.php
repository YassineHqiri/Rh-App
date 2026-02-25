@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Edit User</h1>
    <p class="mt-1 text-sm text-gray-500">Update account settings for {{ e($user->name) }}.</p>
</div>

<div class="bg-white rounded-xl shadow ring-1 ring-gray-200">
    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')
        <div class="p-6 sm:p-8">
            @include('users._form')
        </div>
        <div class="flex items-center justify-end gap-x-3 border-t border-gray-200 px-6 py-4 sm:px-8">
            <a href="{{ route('users.index') }}" class="rounded-lg px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition">Cancel</a>
            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
