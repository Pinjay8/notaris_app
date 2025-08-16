<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\Notaris;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SummaryNotarisController extends Controller
{
    // public function summary(Request $request)
    // {
    //     try {
    //         $year = $request->year ?? now()->year;
    //         $month = $request->month;
    //         $filter = $request->filter;

    //         // Validasi filter
    //         if ($filter && !in_array($filter, ['all', 'this_week'])) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Filter tidak valid. Gunakan: all, this_week'
    //             ], 400);
    //         }

    //         // Total Notaris
    //         $totalNotaris = Notaris::count();

    //         // Total client berdasarkan filter
    //         $query = Client::query();
    //         if ($filter === 'this_week') {
    //             $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    //         } elseif ($month) {
    //             $query->whereYear('created_at', $year)->whereMonth('created_at', $month);
    //         }
    //         $totalClients = $query->count();

    //         // Total client per bulan (1 tahun)
    //         $monthlyClients = Client::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
    //             ->whereYear('created_at', $year)
    //             ->groupByRaw('MONTH(created_at)')
    //             ->get();

    //         // Total client per notaris
    //         $clientsPerNotaris = Notaris::withCount('clients') // pastikan relasi `clients` ada
    //             ->get(['id', 'name']);

    //         // Last login semua notaris
    //         $lastLogins = DB::table('activity_logs as a')
    //             ->select('a.user_id', 'u.name', DB::raw('MAX(a.created_at) as last_login_at'))
    //             ->join('users as u', 'u.id', '=', 'a.user_id')
    //             ->where('u.role', 'notaris')
    //             ->where('a.action', 'login') // bisa diganti jadi 'logout' kalau mau
    //             ->groupBy('a.user_id', 'u.name')
    //             ->get();

    //         return response()->json([
    //             'status' => true,
    //             'total_notaris' => $totalNotaris,
    //             'total_clients' => $totalClients,
    //             'monthly_clients' => $monthlyClients,
    //             'clients_per_notaris' => $clientsPerNotaris,
    //             'last_logins' => $lastLogins,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         Log::error('Error summary notaris: ' . $e->getMessage());
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Terjadi kesalahan pada server'
    //         ], 500);
    //     }
    // }

    public function index()
    {
        $now = Carbon::now();
        $startOfWeek = $now->startOfWeek();
        $startOfMonth = $now->copy()->startOfMonth();

        $totalNotaris = Notaris::count();
        $totalClients = Client::count();

        // Total client per bulan
        $clientsMonthly = Client::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        // Total client minggu ini
        $clientsThisWeek = Client::whereBetween('created_at', [$startOfWeek, now()])->count();

        // Total client per notaris

        $clientsPerNotaris = Notaris::withCount('clients')->get();

        // Last login setiap notaris
        $lastLogins = ActivityLog::where('data_type', 'users')
            ->where('action', 'login') // Sesuaikan jika aksi login berbeda
            ->select('user_id', DB::raw('MAX(created_at) as last_login'))
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        $notarisList = Notaris::all()->map(function ($notaris) use ($lastLogins) {
            return [
                'id' => $notaris->id,
                'display_name' => $notaris->display_name,
                'last_login' => optional($lastLogins->get($notaris->id))->last_login ?? 'Belum login',
                'total_clients' => $notaris->clients()->count(),
            ];
        });

        return response()->json([
            'total_notaris' => $totalNotaris,
            'total_clients' => $totalClients,
            'clients_monthly' => $clientsMonthly,
            'clients_this_week' => $clientsThisWeek,
            'clients_per_notaris' => $notarisList,
        ]);
    }


    public function filter(Request $request, $id)
    {
        $period = $request->input('period', 'monthly');
        $startDateParam = $request->input('start_date');
        $endDateParam = $request->input('end_date');

        // Gunakan start_date & end_date dari request jika ada, jika tidak gunakan dari period
        if ($startDateParam && $endDateParam) {
            try {
                $start = Carbon::parse($startDateParam)->startOfDay();
                $end = Carbon::parse($endDateParam)->endOfDay();
            } catch (\Exception $e) {
                return response()->json(['error' => 'Invalid date format. Use YYYY-MM-DD.'], 400);
            }
        } else {
            // Default berdasarkan period
            switch ($period) {
                case 'weekly':
                    $start = Carbon::now()->startOfWeek();
                    $end = Carbon::now()->endOfWeek();
                    break;
                case 'monthly':
                    $start = Carbon::now()->startOfMonth();
                    $end = Carbon::now()->endOfMonth();
                    break;
                case 'yearly':
                    $start = Carbon::now()->startOfYear();
                    $end = Carbon::now()->endOfYear();
                    break;
                default:
                    return response()->json(['error' => 'Invalid period value. Use weekly, monthly, or yearly.'], 400);
            }
        }

        // Filter client untuk notaris tertentu di rentang tanggal
        $filteredClients = Client::where('notaris_id', $id)
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $totalClients = $filteredClients->count();

        // Ambil informasi notaris
        $notaris = Notaris::find($id);
        $displayName = $notaris ? $notaris->display_name : null;

        return response()->json([
            'notaris_id' => $id,
            'display_name' => $displayName,
            'period' => $period,
            'start_date' => $start->toDateString(),
            'end_date' => $end->toDateString(),
            'total_clients' => $totalClients,
        ]);
    }





    // Get All Clients
    public function allClients(Request $request)
    {
        try {
            $rowPerPage = $request->input('rowPerPage', 10); // default 20

            $clients = Client::latest()->paginate($rowPerPage);

            if ($clients->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data klien tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $clients->items(),
                'pagination' => [
                    'totalItems'  => $clients->total(),
                    'totalPages'  => $clients->lastPage(),
                    'currentPage' => $clients->currentPage(),
                    'hasNextPage' => $clients->hasMorePages(),
                    'hasPrevPage' => $clients->currentPage() > 1,
                    'offset'      => ($clients->currentPage() - 1) * $clients->perPage(),
                    'rowPerPage'  => $clients->perPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error get all clients: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data klien'
            ], 500);
        }
    }

    public function clientsByNotaris($id)
    {
        try {
            $notaris = Notaris::find($id); // Ganti ini

            if (!$notaris) {
                return response()->json([
                    'status' => false,
                    'message' => 'Notaris tidak ditemukan'
                ], 404);
            }

            $clients = Client::where('notaris_id', $notaris->id)->latest()->get();

            if ($clients->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada klien untuk notaris ini'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data klien berhasil diambil',
                'data' => [
                    'notaris' => [
                        'id' => $notaris->id,
                        'name' => $notaris->display_name,
                    ],
                    'clients' => $clients
                ]
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error get clients by notaris: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        }
    }
}
