<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\AuditLog;
use App\Models\Department;
use App\Models\Employee;
use App\Services\AuditService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Employee::class, 'employee');
    }

    public function index(Request $request)
    {
        $query = Employee::with('department');

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        if ($request->filled('status') && in_array($request->input('status'), ['active', 'inactive'])) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->input('department_id'));
        }

        if ($request->filled('sort')) {
            $sortField = $request->input('sort');
            $sortDir = $request->input('direction', 'asc');
            $allowedSorts = ['first_name', 'last_name', 'email', 'position', 'salary', 'hire_date', 'status'];

            if (in_array($sortField, $allowedSorts) && in_array($sortDir, ['asc', 'desc'])) {
                $query->orderBy($sortField, $sortDir);
            }
        } else {
            $query->latest();
        }

        $employees = $query->paginate(25)->withQueryString();
        $departments = Department::orderBy('name')->get();

        return view('employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('employees.create', compact('departments'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $employee = Employee::create($data);

        AuditService::logModelCreated($employee);

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'creator', 'updater', 'notes.creator', 'documents']);

        $auditLogs = AuditLog::forModel(Employee::class, $employee->id)
            ->with('user')
            ->latest('created_at')
            ->take(20)
            ->get();

        return view('employees.show', compact('employee', 'auditLogs'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::orderBy('name')->get();
        return view('employees.edit', compact('employee', 'departments'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $oldValues = $employee->only([
            'first_name', 'last_name', 'email', 'phone',
            'position', 'department_id', 'salary', 'hire_date',
            'contract_end_date', 'date_of_birth', 'address',
            'emergency_contact', 'emergency_phone', 'status',
        ]);

        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        $employee->update($data);

        AuditService::logModelUpdated($employee, $oldValues);

        return redirect()
            ->route('employees.show', $employee)
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        AuditService::logModelDeleted($employee);

        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}
