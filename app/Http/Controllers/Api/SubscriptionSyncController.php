<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Models\Subscriptions;
use Illuminate\Http\Request;

class SubscriptionSyncController extends Controller
{

    public function store(StoreSubscriptionRequest $request)
    {
        try {
            $subscription = Subscriptions::create($request->validated());

            return response()->json([
                'message' => 'Data subscription berhasil disimpan.',
                'data' => $subscription
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan data subscription.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $subscription = Subscriptions::all();

        return response()->json([
            'success' => true,
            'message' => 'Subscription data successfully retrieved',
            'data' => $subscription
        ], 200);
    }
}
