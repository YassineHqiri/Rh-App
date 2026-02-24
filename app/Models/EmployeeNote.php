<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeNote extends Model
{
    protected $fillable = [
        'employee_id',
        'content',
        'is_private',
        'created_by',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
