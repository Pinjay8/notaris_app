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
            ->where('user_id', auth()->id())
            ->when($search, function ($query, $search) {
                $query->whereHas('plan', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search]); // ✅ best practice

        return view('pages.Subscription.index', compact('subscriptions'));
    }
}
