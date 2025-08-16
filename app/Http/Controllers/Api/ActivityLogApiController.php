<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogApiController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'from'    => 'required|date',
            'to'      => 'required|date|after_or_equal:from',
            'rowPerPage' => 'nullable|integer|min:1', // opsional
            'page'       => 'nullable|integer|min:1', // opsional
        ]);

        $rowPerPage = $request->input('rowPerPage', 20); // default 20

        $logs = ActivityLog::where('user_id', $request->user_id)
            ->whereDate('created_at', '>=', $request->from)
            ->whereDate('created_at', '<=', $request->to)
            ->orderByDesc('created_at')
            ->paginate($rowPerPage);

        return response()->json([
            'status'  => true,
            'message' => 'Data log ditemukan.',
            'data'    => $logs->items(),
            'pagination' => [
                'totalItems'  => $logs->total(),
                'totalPages'  => $logs->lastPage(),
                'currentPage' => $logs->currentPage(),
                'hasNextPage' => $logs->hasMorePages(),
                'hasPrevPage' => $logs->currentPage() > 1,
                'offset'      => ($logs->currentPage() - 1) * $logs->perPage(),
                'rowPerPage'  => $logs->perPage(),
            ],
        ]);
    }
}
