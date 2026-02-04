<?php

namespace App\Http\Controllers;

use App\Models\NotaryCost;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;

class PublicPaymentController extends Controller
{
    public function show($token)
    {
        try {
            $paymentCode = Crypt::decryptString($token);
        } catch (\Exception $e) {
            abort(404);
        }

        $cost = NotaryCost::with(['payments', 'client'])
            ->where('payment_code', $paymentCode)
            ->firstOrFail();

        return view('pages.Public.payment', compact('cost'));
    }
}
