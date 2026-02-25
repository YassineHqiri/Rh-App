<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%");
            });
        }

        if ($request->filled('role') && in_array($request->input('role'), ['admin', 'hr', 'it_admin'])) {
            $query->where('role', $request->input('role'));
        }

        if ($request->filled('status') && in_array($request->input('status'), ['active', 'inactive'])) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $users = $query->latest()->paginate(25)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in(['admin', 'hr', 'it_admin'])],
            'is_active' => ['nullable', 'boolean'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['email_verified_at'] = now();

        $user = User::create($data);

        AuditService::log(
            'user_created',
            User::class,
            $user->id,
            null,
            $user->only(['name', 'email', 'role', 'is_active'])
        );

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', Rule::in(['admin', 'hr', 'it_admin'])],
            'is_active' => ['nullable', 'boolean'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $oldValues = $user->only(['name', 'email', 'role', 'is_active']);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active', false);

        $user->update($data);

        AuditService::log(
            'user_updated',
            User::class,
            $user->id,
            $oldValues,
            $user->only(['name', 'email', 'role', 'is_active'])
        );

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function toggleStatus(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot deactivate your own account.');
        }

        $oldValues = ['is_active' => $user->is_active];
        $user->update(['is_active' => !$user->is_active]);

        AuditService::log(
            'user_status_changed',
            User::class,
            $user->id,
            $oldValues,
            ['is_active' => $user->is_active]
        );

        return back()->with('success', 'User status updated successfully.');
    }
}
