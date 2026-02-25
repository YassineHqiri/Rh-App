<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isHr(): bool
    {
        return $this->role === 'hr';
    }

    public function isItAdmin(): bool
    {
        return $this->role === 'it_admin';
    }

    public function hasHrAccess(): bool
    {
        return $this->is_active && in_array($this->role, ['admin', 'hr', 'it_admin']);
    }

    public function canManageUsers(): bool
    {
        return $this->is_active && $this->isItAdmin();
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}
