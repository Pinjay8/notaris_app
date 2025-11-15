<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notaris;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class NotarisController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            // default 10 data per halaman, bisa diganti dengan ?limit=5
            $limit = $request->input('limit', 10);

            $query = Notaris::select([
                'id',
                'user_id',
                'first_name',
                'last_name',
                'display_name',
                'office_name',
                'office_address',
                'image',
                'background',
                'address',
                'phone',
                'email',
                'gender',
                'information',
            ]);

            // pakai pagination tapi jumlah data per halaman mengikuti limit
            $notaris = $query->paginate($limit);

            return response()->json([
                'success' => true,
                'message' => 'Data notaris berhasil diambil',
                'data'    => $notaris->items(),
                'pagination' => [
                    'totalItems'   => $notaris->total(),
                    'totalPages'   => $notaris->lastPage(),
                    'currentPage'  => $notaris->currentPage(),
                    'hasNextPage'  => $notaris->hasMorePages(),
                    'hasPrevPage'  => $notaris->currentPage() > 1,
                    'offset'       => ($notaris->currentPage() - 1) * $notaris->perPage(),
                    'rowPerPage'   => $notaris->perPage(),
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data notaris', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data notaris',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
