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
            'limit'   => 'nullable|integer|min:1', // opsional, jumlah data per halaman
            'page'    => 'nullable|integer|min:1', // opsional halaman
        ]);

        // default 20 data per halaman, bisa diganti dengan ?limit=5
        $limit = $request->input('limit', 20);

        $query = ActivityLog::where('user_id', $request->user_id)
            ->whereDate('created_at', '>=', $request->from)
            ->whereDate('created_at', '<=', $request->to)
            ->orderByDesc('created_at');

        // pakai pagination, jumlah per halaman mengikuti limit
        $logs = $query->paginate($limit);

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
