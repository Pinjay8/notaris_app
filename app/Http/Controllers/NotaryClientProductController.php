<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotaryClientService;

class NotaryClientProductController extends Controller
{
    protected $notaryClientservice;

    public function __construct(NotaryClientService $notaryClientservice)
    {
        $this->notaryClientservice = $notaryClientservice;
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'registration_code',
            'notaris_id',
            'client_id',
            'product_id',
            'status'
        ]);
        $products = $this->notaryClientservice->listProducts($filters);
        return view('pages.ManagementProcess.index', compact('products', 'filters'));
    }

    public function detail(Request $request, $registration_code)
    {
        $keys = [
            'registration_code' => $registration_code,
            'notaris_id' => $request->query('notaris_id'),
            'client_id' => $request->query('client_id'),
            'product_id' => $request->query('product_id'),
        ];

        $product = $this->notaryClientservice->getProductByCompositeKey($keys);
        $progresses = $this->notaryClientservice->getProgressHistory($keys);

        return view('pages.ManagementProcess.detail', compact('product', 'progresses'));
    }

    public function addProgress(Request $request)
    {
        $keys = $request->only(['registration_code', 'notaris_id', 'client_id', 'product_id']);

        $validated = $request->validate([
            'progress' => 'required|string',
            'progress_date' => 'nullable|date',
            'note' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $this->notaryClientservice->addProgress($keys, $validated);

        return redirect()->back()->with('success', 'Progress berhasil ditambahkan');
    }

    public function markDone(Request $request)
    {
        $keys = $request->only(['registration_code', 'notaris_id', 'client_id', 'product_id']);

        $this->notaryClientservice->markCompleted($keys);

        return redirect()->back()->with('success', 'Status berhasil diubah menjadi done');
    }
}
