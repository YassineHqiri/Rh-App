<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasHrAccess();
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')->id;

        return [
            'first_name' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-\.\']+$/u'],
            'last_name' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-\.\']+$/u'],
            'email' => ['required', 'email', 'max:255', Rule::unique('employees')->ignore($employeeId)],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[\d\s\+\-\(\)]+$/'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'position' => ['required', 'string', 'max:150'],
            'salary' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'hire_date' => ['required', 'date', 'before_or_equal:today'],
            'contract_end_date' => ['nullable', 'date', 'after:hire_date'],
            'status' => ['required', 'in:active,inactive'],
            'address' => ['nullable', 'string', 'max:500'],
            'emergency_contact' => ['nullable', 'string', 'max:100'],
            'emergency_phone' => ['nullable', 'string', 'max:20', 'regex:/^[\d\s\+\-\(\)]+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.regex' => 'First name may only contain letters, spaces, hyphens, dots and apostrophes.',
            'last_name.regex' => 'Last name may only contain letters, spaces, hyphens, dots and apostrophes.',
            'phone.regex' => 'Phone may only contain digits, spaces, plus signs, hyphens and parentheses.',
            'salary.max' => 'Salary cannot exceed 999,999.99 DH.',
            'hire_date.before_or_equal' => 'Hire date cannot be in the future.',
        ];
    }
}
