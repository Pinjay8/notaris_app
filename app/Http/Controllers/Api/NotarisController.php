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
            $rowPerPage = $request->input('rowPerPage', 10); // default 20
            $notaris = Notaris::select([
                'id',
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
            ])->paginate($rowPerPage);

            return response()->json([
                'success' => true,
                'message' => 'Data notaris berhasil diambil',
                'data' => $notaris->items(),
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
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
