<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest('created_at');

        if ($request->filled('action')) {
            $allowed = ['created', 'updated', 'deleted', 'login_success', 'login_failed', 'logout'];
            if (in_array($request->input('action'), $allowed)) {
                $query->where('action', $request->input('action'));
            }
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->input('date_to') . ' 23:59:59');
        }

        $logs = $query->paginate(25)->withQueryString();

        return view('audit.index', compact('logs'));
    }
}
