<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeNote;
use App\Services\AuditService;
use Illuminate\Http\Request;

class EmployeeNoteController extends Controller
{
    public function store(Request $request, Employee $employee)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:2000'],
            'is_private' => ['boolean'],
        ]);

        $note = $employee->notes()->create([
            'content' => $request->input('content'),
            'is_private' => $request->boolean('is_private'),
            'created_by' => $request->user()->id,
        ]);

        AuditService::logModelCreated($note);

        return back()->with('success', 'Note added successfully.');
    }

    public function destroy(Employee $employee, EmployeeNote $note)
    {
        if ($note->employee_id !== $employee->id) {
            abort(404);
        }

        if ($note->created_by !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'You can only delete your own notes.');
        }

        AuditService::logModelDeleted($note);
        $note->delete();

        return back()->with('success', 'Note deleted successfully.');
    }
}
