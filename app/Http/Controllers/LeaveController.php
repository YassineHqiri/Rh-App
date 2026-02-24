<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Services\AuditService;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = LeaveRequest::with(['employee', 'leaveType', 'reviewer']);

        if ($request->filled('status') && in_array($request->input('status'), ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('employee_id')) {
            $query->where('employee_id', $request->input('employee_id'));
        }

        if ($request->filled('leave_type_id')) {
            $query->where('leave_type_id', $request->input('leave_type_id'));
        }

        $leaveRequests = $query->latest()->paginate(25)->withQueryString();
        $employees = Employee::active()->orderBy('first_name')->get();
        $leaveTypes = LeaveType::active()->orderBy('name')->get();
        $pendingCount = LeaveRequest::pending()->count();

        return view('leaves.index', compact('leaveRequests', 'employees', 'leaveTypes', 'pendingCount'));
    }

    public function create()
    {
        $employees = Employee::active()->orderBy('first_name')->get();
        $leaveTypes = LeaveType::active()->orderBy('name')->get();

        return view('leaves.create', compact('employees', 'leaveTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'exists:employees,id'],
            'leave_type_id' => ['required', 'exists:leave_types,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $startDate = \Carbon\Carbon::parse($data['start_date']);
        $endDate = \Carbon\Carbon::parse($data['end_date']);
        $data['total_days'] = $startDate->diffInWeekdays($endDate) + 1;
        $data['created_by'] = $request->user()->id;

        $leaveRequest = LeaveRequest::create($data);

        AuditService::logModelCreated($leaveRequest);

        return redirect()
            ->route('leaves.show', $leaveRequest)
            ->with('success', 'Leave request created successfully.');
    }

    public function show(LeaveRequest $leave)
    {
        $leave->load(['employee.department', 'leaveType', 'reviewer', 'creator']);

        $employeeLeaveStats = LeaveRequest::where('employee_id', $leave->employee_id)
            ->where('status', 'approved')
            ->whereYear('start_date', now()->year)
            ->selectRaw('leave_type_id, SUM(total_days) as total_used')
            ->groupBy('leave_type_id')
            ->with('leaveType')
            ->get();

        return view('leaves.show', compact('leave', 'employeeLeaveStats'));
    }

    public function approve(Request $request, LeaveRequest $leave)
    {
        abort_unless($request->user()?->isAdmin(), 403, 'Only admins can approve leave requests.');

        if ($leave->status !== 'pending') {
            return back()->with('error', 'This leave request has already been processed.');
        }

        $request->validate([
            'review_note' => ['nullable', 'string', 'max:500'],
        ]);

        $oldValues = $leave->only(['status', 'reviewed_by', 'reviewed_at', 'review_note']);

        $leave->update([
            'status' => 'approved',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'review_note' => $request->input('review_note'),
        ]);

        AuditService::logModelUpdated($leave, $oldValues);

        return back()->with('success', 'Leave request approved.');
    }

    public function reject(Request $request, LeaveRequest $leave)
    {
        abort_unless($request->user()?->isAdmin(), 403, 'Only admins can reject leave requests.');

        if ($leave->status !== 'pending') {
            return back()->with('error', 'This leave request has already been processed.');
        }

        $request->validate([
            'review_note' => ['nullable', 'string', 'max:500'],
        ]);

        $oldValues = $leave->only(['status', 'reviewed_by', 'reviewed_at', 'review_note']);

        $leave->update([
            'status' => 'rejected',
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'review_note' => $request->input('review_note'),
        ]);

        AuditService::logModelUpdated($leave, $oldValues);

        return back()->with('success', 'Leave request rejected.');
    }
}
