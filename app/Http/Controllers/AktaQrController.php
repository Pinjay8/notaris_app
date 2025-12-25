<?php

namespace App\Http\Controllers;

use App\Models\NotaryAktaTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class AktaQrController extends Controller
{

    public function show(Request $request, $transaction_code)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        try {
            $decodedCode = Crypt::decryptString($transaction_code);
        } catch (\Exception $e) {
            abort(404); // jika URL diubah / rusak
        }

        $akta = NotaryAktaTransaction::with(['client', 'akta_type', 'notaris'])
            ->where('transaction_code', $decodedCode)
            ->firstOrFail();

        return view('pages.PreviewTransaction.index', compact('akta'));
    }
}
