<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasHrAccess();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('departments')->ignore($this->route('department')->id)],
            'description' => ['nullable', 'string', 'max:500'],
            'head_id' => ['nullable', 'exists:employees,id'],
        ];
    }
}
