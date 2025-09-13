<?php

namespace App\Http\Controllers;

use App\Models\NotaryCost;
use App\Models\NotaryPayment;
use App\Models\NotaryPaymentt;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class NotaryPaymenttController extends Controller
{
    public function index(Request $request)
    {
        $cost = null;
        if ($request->has('pic_document_code')) {
            $cost = NotaryCost::with('payments')
                ->whereHas('picDocument', fn($q) => $q->where('pic_document_code', $request->pic_document_code))
                ->first();
        }

        return view('pages.Biaya.Pembayaran.index', compact('cost'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_code'   => 'required',
            'payment_type'   => 'required',
            'amount'         => 'required',
            'payment_date'   => 'required|date',
            'payment_method' => 'required|string',
            'payment_file'   => 'required|file',
        ]);

        $cost = NotaryCost::where('payment_code', $request->payment_code)->firstOrFail();


        $amount = (float) str_replace('.', '', $request->amount);
        // Simpan ke notary_payments
        NotaryPayment::create([
            'notaris_id'      => $cost->notaris_id,
            'client_id'       => $cost->client_id,
            'pic_document_id' => $cost->pic_document_id,
            'payment_code'    => $cost->payment_code,
            'payment_type'    => $request->payment_type,
            'amount'          => $amount,
            'payment_date'    => $request->payment_date,
            'payment_method'  => $request->payment_method,
            'payment_file'    => $request->file('payment_file')?->storeAs('documents', $request->file('payment_file')->getClientOriginalName()),
            'note'            => $request->note,
            'is_valid'        => false,
        ]);


        // Update notary_cost
        // Bersihkan amount dari titik sebelum dipakai

        $cost->amount_paid = $cost->amount_paid ?? 0;

        // Tambahkan nominal baru
        $cost->amount_paid += $amount;

        if ($cost->amount_paid > $cost->total_cost) {
            notyf()->position('x', 'right')->position('y', 'top')->error('Jumlah pembayaran melebihi total biaya!');
            return back()->withInput();
        }

        // Update status
        if ($cost->amount_paid >= $cost->total_cost) {
            $cost->payment_status = 'paid';
        } elseif ($cost->amount_paid > 0) {
            $cost->payment_status = 'partial';
        } else {
            $cost->payment_status = 'unpaid';
        }

        $cost->save();

        notyf()->position('x', 'right')->position('y', 'top')->success('Pembayaran berhasil disimpan.');
        return back();
    }

    public function print($payment_code)
    {
        $cost = NotaryCost::with('payments')
            ->where('payment_code', $payment_code)
            ->firstOrFail();

        // Render blade ke HTML
        $html = view('pages.Biaya.Pembayaran.print', compact('cost'))->render();

        // Inisialisasi mPDF
        $mpdf = new Mpdf([
            'default_font' => 'dejavusans',
            'format'       => 'A4',
            'margin_top'   => 15,
            'margin_bottom' => 15,
            'margin_left'  => 15,
            'margin_right' => 15,
        ]);

        // Tulis HTML ke PDF
        $mpdf->WriteHTML($html);

        // Output langsung ke browser (inline)
        return response($mpdf->Output("Pembayaran-{$payment_code}.pdf", 'I'))
            ->header('Content-Type', 'application/pdf');
    }

    public function valid($id)
    {
        $payment = NotaryPayment::findOrFail($id);
        $payment->is_valid = true;
        $payment->save();

        notyf()->position('x', 'right')->position('y', 'top')->success('Pembayaran berhasil divalidasi.');
        return back();
    }
}
