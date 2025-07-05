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
        ]);

        $logs = ActivityLog::where('user_id', $request->user_id)
            ->whereDate('created_at', '>=', $request->from)
            ->whereDate('created_at', '<=', $request->to)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data log ditemukan.',
            'data' => $logs,
        ]);
    }
}
