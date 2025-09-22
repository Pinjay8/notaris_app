<?php

namespace App\Http\Controllers;

use App\Models\NotaryCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;


class ReportPaymentController extends Controller
{
    public function index(Request $request)
    {
        $costs = collect(); // default kosong

        // cek apakah ada filter
        if ($request->filled('start_date') || $request->filled('end_date') || $request->filled('status')) {
            $query =  NotaryCost::with('client');

            if ($request->filled('start_date')) {
                $query->whereDate('created_at', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate('created_at', '<=', $request->end_date);
            }

            if ($request->status && $request->status != 'all') {
                $query->where('payment_status', $request->status);
            }

            $costs = $query->latest()->get();
        }

        return view('pages.Laporan.index', compact('costs'));
    }

    public function print(Request $request)
    {
        $query = NotaryCost::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        if ($request->status && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $costs = $query->latest()->get();

        // Render Blade ke HTML
        $html = View::make('pages.Laporan.print', compact('costs'))->render();

        // Inisialisasi mPDF (A4 portrait, bisa diubah ke landscape)
        $mpdf = new Mpdf(['format' => 'A4-L']); // L = landscape

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('Laporan-Pembayaran.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }
}
