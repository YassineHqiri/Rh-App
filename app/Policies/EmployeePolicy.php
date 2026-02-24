<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasHrAccess();
    }

    public function view(User $user, Employee $employee): bool
    {
        return $user->hasHrAccess();
    }

    public function create(User $user): bool
    {
        return $user->hasHrAccess();
    }

    public function update(User $user, Employee $employee): bool
    {
        return $user->hasHrAccess();
    }

    public function delete(User $user, Employee $employee): bool
    {
        return $user->hasHrAccess();
    }

    public function restore(User $user, Employee $employee): bool
    {
        return $user->hasHrAccess();
    }

    public function forceDelete(User $user, Employee $employee): bool
    {
        return $user->isAdmin();
    }
}
