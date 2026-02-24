<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Services\AuditService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Department::withCount('employees', 'activeEmployees');

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        $departments = $query->orderBy('name')->paginate(25)->withQueryString();

        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        $employees = Employee::active()->orderBy('first_name')->get();
        return view('departments.create', compact('employees'));
    }

    public function store(StoreDepartmentRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        $department = Department::create($data);

        AuditService::logModelCreated($department);

        return redirect()
            ->route('departments.show', $department)
            ->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        $department->load(['head', 'creator', 'updater']);
        $employees = $department->employees()->with('creator')->orderBy('first_name')->paginate(10);

        return view('departments.show', compact('department', 'employees'));
    }

    public function edit(Department $department)
    {
        $employees = Employee::active()->orderBy('first_name')->get();
        return view('departments.edit', compact('department', 'employees'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $oldValues = $department->only(['name', 'description', 'head_id']);

        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        $department->update($data);

        AuditService::logModelUpdated($department, $oldValues);

        return redirect()
            ->route('departments.show', $department)
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        if ($department->employees()->count() > 0) {
            return back()->with('error', 'Cannot delete a department that has employees assigned to it.');
        }

        AuditService::logModelDeleted($department);
        $department->delete();

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}
