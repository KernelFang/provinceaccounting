<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the audit logs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $logs = Audit::query();

        // Filter by action type (create, update, delete, login, logout)
        if ($request->filled('action')) {
            $logs->where('action', $request->get('action'));
        }

        // Filter by model type (e.g., Expense, User, etc.)
        if ($request->filled('auditable_type')) {
            $logs->where('auditable_type', $request->get('auditable_type'));
        }

        // Filter by user (who performed the action)
        if ($request->filled('user_id')) {
            $logs->where('user_id', $request->get('user_id'));
        }

        // Date range filtering
        $rangeInput = $request->get('date_range');
        $start = null;
        $end = null;

        if ($rangeInput) {
            $r = trim($rangeInput);

            if (preg_match('/\d{4}-\d{2}-\d{2}\s*-\s*\d{4}-\d{2}-\d{2}/', $r) || preg_match('/\d{1,2}\/\d{1,2}\/\d{4}\s*-\s*\d{1,2}\/\d{1,2}\/\d{4}/', $r)) {
                $parts = preg_split('/\s*-\s*/', $r, 2);
                if (count($parts) === 2) {
                    try {
                        $a = \Carbon\Carbon::parse($parts[0]);
                        $b = \Carbon\Carbon::parse($parts[1]);
                        $start = $a->copy()->startOfDay();
                        $end = $b->copy()->endOfDay();
                    } catch (\Exception $e) {
                        // Ignore invalid date format
                        $start = null;
                        $end = null;
                    }
                }
            }
        }

        // If no valid input, fallback to current month's start and end
        if (! $start || ! $end) {
            $start = \Carbon\Carbon::now()->startOfMonth();
            $end = \Carbon\Carbon::now()->endOfMonth();
        }

        // Apply date range filter only if valid start and end are provided
        if ($start && $end) {
            $logs->whereBetween('created_at', [$start, $end]);
        }

        // Set a default sorting and paginate (with size control)
        $perPageInput = $request->query('per_page');
        $defaultPerPage = 25;
        if ($perPageInput === 'all') {
            $logs = $logs->orderByDesc('created_at')->get();
        } else {
            $perPage = is_numeric($perPageInput) ? (int) $perPageInput : $defaultPerPage;
            $allowed = [$defaultPerPage, 100, 500, 1000, 5000];
            if (! in_array($perPage, $allowed)) {
                $perPage = $defaultPerPage;
            }
            $logs = $logs->orderByDesc('created_at')->paginate($perPage);
        }

        $logsTotal = method_exists($logs, 'total') ? $logs->total() : $logs->count();

        // Prepare dropdown data based on existing audits
        $actions = Audit::select('action')->distinct()->orderBy('action')->pluck('action');
        $types = Audit::select('auditable_type')->distinct()->orderBy('auditable_type')->pluck('auditable_type');
        $users = Audit::select('user_id')->distinct()->whereNotNull('user_id')->pluck('user_id');

        return response()->view('audit_logs.index', compact('logs', 'actions', 'types', 'users', 'start', 'end', 'logsTotal'));
    }

    /**
     * Display a single audit log details.
     */
    public function show(string $id)
    {
        $log = Audit::with('user')->findOrFail($id);

        return response()->view('audit_logs.show', compact('log'));
    }
}
