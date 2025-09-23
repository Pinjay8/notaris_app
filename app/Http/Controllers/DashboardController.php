<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\NotaryClientDocument;
use App\Models\NotaryConsultation;
use App\Models\NotaryPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $notarisId = Auth::user()->notaris_id;

        // Statistik utama
        $totalClients = Client::where('notaris_id', $notarisId)->count();
        // $inProgressDocs = NotaryClientDocument::where('status', 'valid')->count();
        $doneDocs = NotaryClientDocument::where('notaris_id', $notarisId)->count();
        $activeConsultations = NotaryConsultation::where('notaris_id', $notarisId)->count();
        $paymentsCount = NotaryPayment::where('notaris_id', $notarisId)->count();

        // Dokumen masuk per bulan (untuk chart)
        // $monthlyDocs = NotaryClientDocument::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        //     ->groupBy('month')
        //     ->pluck('total', 'month');

        $clientsPerMonth = Client::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->where('notaris_id', $notarisId)
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // isi label bulan Jan–Dec
        $labels = collect(range(1, 12))->map(fn($m) => date('M', mktime(0, 0, 0, $m, 1)))->toArray();

        // data disusun per bulan (kalau tidak ada diisi 0)
        $data = [];
        foreach (range(1, 12) as $m) {
            $data[] = $clientsPerMonth[$m] ?? 0;
        }

        // 5 klien terbaru (untuk tabel)
        $latestClients = Client::where('notaris_id', $notarisId)->latest()->take(5)->get();

        $payments = NotaryPayment::where('notaris_id', $notarisId)->latest()->take(5)->get();

        return view('pages.dashboard', compact(
            'totalClients',
            // 'inProgressDocs',
            'doneDocs',
            'activeConsultations',
            // 'monthlyDocs',
            'latestClients',
            'labels',
            'data',
            'payments',
            'paymentsCount',
        ));
    }
}
