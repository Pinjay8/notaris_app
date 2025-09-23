<?php

namespace App\Http\Controllers;

use App\Models\Subscriptions;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $subscriptions = Subscriptions::with(['user', 'plan'])
            ->where('user_id', auth()->user()->id)
            ->when($search, function ($query, $search) {
                $query->whereHas('plan', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->latest('start_date')
            ->get();

        return view('pages.Subscription.index', compact('subscriptions'));
    }
    public function create() {}

    public function store(Request $request) {}

    public function show(Subscriptions $subscriptions) {}

    public function edit(Subscriptions $subscriptions) {}

    public function update(Request $request, Subscriptions $subscriptions) {}

    public function destroy(Subscriptions $subscriptions) {}
}
