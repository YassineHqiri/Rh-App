<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    protected $fillable = [
        'employee_id',
        'title',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'category',
        'uploaded_by',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'contract' => 'Contract',
            'id_document' => 'ID Document',
            'certificate' => 'Certificate',
            default => 'Other',
        };
    }
}
