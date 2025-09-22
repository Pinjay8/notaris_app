<?php

namespace App\Http\Controllers;

use App\Models\PicProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

class ReportProcessController extends Controller
{

    public function index(Request $request)
    {
        $processes = collect(); // default kosong
        $query =  PicProcess::query();

        // cek apakah ada filter
        if ($request->filled('start_date') || $request->filled('end_date')) {

            if ($request->filled('start_date')) {
                $query->whereDate('created_at', '>=', $request->start_date);
            }

            if ($request->filled('end_date')) {
                $query->whereDate('created_at', '<=', $request->end_date);
            }
            $processes = $query->orderBy('updated_at', 'desc')->paginate(10);
        }

        return view('pages.Laporan.Pengurusan.index', compact('processes'));
    }
    public function print(Request $request)
    {
        $query = PicProcess::query();

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $processes = $query->latest()->get();

        // Render blade ke HTML
        $html = View::make('pages.Laporan.Pengurusan.print', compact('processes'))->render();

        // Buat instance mPDF
        $mpdf = new Mpdf(['format' => 'A4-L']); // L = landscape

        $mpdf->WriteHTML($html);
        return response($mpdf->Output('Laporan-Pengurusan.pdf', 'I'))
            ->header('Content-Type', 'application/pdf');
    }
}
