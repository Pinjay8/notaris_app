<?php

namespace App\Http\Controllers;

use App\Models\NotaryAktaTransaction;
use App\Models\NotaryRelaasAkta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class NotaryLaporanAktaController extends Controller
{
    //


    public function index(Request $request)
    {
        $queryType = $request->get('type'); // partij / relaas
        $startDate = $request->get('start_date');
        $endDate   = $request->get('end_date');

        $data = collect(); // default kosong

        if ($queryType && $startDate && $endDate) {
            if ($queryType === 'akta-notaris') {
                $data = NotaryAktaTransaction::whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ])->where('notaris_id', auth()->user()->notaris_id)->get();
            } elseif ($queryType === 'ppat') {
                $data = NotaryRelaasAkta::whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ])->where('notaris_id', auth()->user()->notaris_id)->get();
            }
        }

        return view('pages.BackOffice.LaporanAkta.index', [
            'data'      => $data,
            'queryType' => $queryType,
            'startDate' => $startDate,
            'endDate'   => $endDate
        ]);
    }


    public function exportPdf(Request $request)
    {
        $queryType = $request->get('type'); // partij / relaas
        $startDate = $request->get('start_date');
        $endDate   = $request->get('end_date');

        $data = collect(); // default kosong

        if ($queryType && $startDate && $endDate) {
            if ($queryType === 'partij') {
                $data = NotaryAktaTransaction::whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ])->get();
            } elseif ($queryType === 'relaas') {
                $data = NotaryRelaasAkta::whereBetween('created_at', [
                    Carbon::parse($startDate)->startOfDay(),
                    Carbon::parse($endDate)->endOfDay()
                ])->get();
            }
        }

        // render view jadi HTML untuk mPDF
        $html = view('pages.BackOffice.LaporanAkta.export', [
            'data'      => $data,
            'queryType' => $queryType,
            'startDate' => $startDate,
            'endDate'   => $endDate
        ])->render();

        // generate PDF
        $mpdf = new Mpdf();
        $mpdf->WriteHTML($html);

        // Output PDF
        return response($mpdf->Output('laporan-akta.pdf', 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="laporan-akta.pdf"');
    }
}
