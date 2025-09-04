<?php

namespace App\Http\Controllers;

use App\Services\NotaryClientService;
use Illuminate\Http\Request;

class NotaryClientWarkahController extends Controller
{

    protected $notaryClientservice;


    public function __construct(NotaryClientService $notaryClientservice)
    {
        $this->notaryClientservice = $notaryClientservice;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only([
            'registration_code',
            'notaris_id',
            'client_id',
            'product_id',
            'status'
        ]);
        $products = $this->notaryClientservice->listWarkah($filters);

        return view('pages.BackOffice.Warkah.index', compact('products', 'filters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $keys = $request->only(['registration_code', 'notaris_id', 'client_id', 'product_id']);

        $validated = $request->validate([
            'warkah_code' => 'nullable',
            'warkah_name' => 'required',
            'note' => 'nullable|string',
            'warkah_link' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'uploaded_at' => 'nullable|date',
            'status' => 'nullable|string',
        ]);

        // handle file upload kalau ada
        if ($request->hasFile('warkah_link')) {
            $validated['warkah_link'] = $request->file('warkah_link')->storeAs('documents', $request->file('warkah_link')->getClientOriginalName());
        }

        // status set new
        $validated['status'] = 'new';

        $this->notaryClientservice->addWarkah($keys, $validated);
        // dd($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Data warkah berhasil ditambahkan');
        return redirect()->back();
    }

    public function markDones(Request $request)
    {
        $keys = $request->only(['registration_code', 'notaris_id', 'client_id', 'product_id']);
        $this->notaryClientservice->markCompleteds($keys);
        notyf()->position('x', 'right')->position('y', 'top')->success('Status berhasil diubah menjadi done');
        return redirect()->back();
    }

    public function updateStatusValid(Request $request)
    {
        $keys = $request->only(['registration_code', 'notaris_id', 'client_id', 'product_id']);
        $this->notaryClientservice->updateStatusWarkah($keys);
        notyf()->position('x', 'right')->position('y', 'top')->success('Status berhasil diubah menjadi valid');
        return redirect()->back();
    }
}
