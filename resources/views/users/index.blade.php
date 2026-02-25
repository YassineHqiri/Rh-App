@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
        <p class="mt-1 text-sm text-gray-500">IT-only access for creating and maintaining application users.</p>
    </div>
    <div class="mt-4 sm:mt-0">
        <a href="{{ route('users.create') }}"
           class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
            Add User
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow ring-1 ring-gray-200 mb-6">
    <div class="p-4">
        <form method="GET" action="{{ route('users.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by name or email..."
                       class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
            </div>
            <div class="sm:w-40">
                <select name="role"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                    <option value="">All Roles</option>
                    <option value="hr" {{ request('role') === 'hr' ? 'selected' : '' }}>HR</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="it_admin" {{ request('role') === 'it_admin' ? 'selected' : '' }}>IT Admin</option>
                </select>
            </div>
            <div class="sm:w-40">
                <select name="status"
                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-gray-800 px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-700 transition">
                Filter
            </button>
        </form>
    </div>
</div>

<div class="bg-white rounded-xl shadow ring-1 ring-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ e($user->name) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ e($user->email) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ str_replace('_', ' ', ucfirst($user->role)) }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium {{ $user->is_active ? 'bg-green-50 text-green-700 ring-1 ring-green-600/20' : 'bg-red-50 text-red-700 ring-1 ring-red-600/20' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-x-3">
                            <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">Edit</a>
                            @if(auth()->id() !== $user->id)
                            <form method="POST" action="{{ route('users.toggle-status', $user) }}">
                                @csrf
                                <button type="submit" class="text-sm font-medium {{ $user->is_active ? 'text-red-600 hover:text-red-500' : 'text-emerald-600 hover:text-emerald-500' }}">
                                    {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="border-t border-gray-200 px-6 py-4">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
