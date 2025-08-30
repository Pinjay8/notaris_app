<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\NotaryLegalisasi;
use Illuminate\Http\Request;
use App\Services\NotaryLegalisasiService;

class NotaryLegalisasiController extends Controller
{

    protected $service;

    public function __construct(NotaryLegalisasiService $service)
    {
        $this->service = $service;
    }


    public function index(Request $request)
    {
        $filters = $request->only(['legalisasi_number', 'sort']);
        $perPage = $request->get('perPage', 10);

        $data = $this->service->list($filters, $perPage);

        return view('pages.BackOffice.Legalisasi.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        return view('pages.BackOffice.Legalisasi.form', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //    dd($request->all());
        // Validasi input
        $validated = $request->validate([
            'client_id'         => 'required|exists:clients,id',
            'legalisasi_number' => 'required|string|max:255|unique:notary_legalisasis,legalisasi_number',
            'applicant_name'    => 'nullable|string|max:255',
            'officer_name'      => 'nullable|string|max:255',
            'document_type'     => 'nullable|string|max:255',
            'document_number'   => 'nullable|string|max:255',
            'request_date'      => 'required|date',
            'release_date'      => 'nullable|date|after_or_equal:request_date',
            'notes'             => 'nullable|string',
            'file_path'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // misal file upload
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->storeAs('documents', $request->file('file_path')->getClientOriginalName());
        }

        $validated['notaris_id'] = auth()->user()->notaris_id;
        // dd($validated);

        // Simpan ke database
        $this->service->create($validated);

        // Tambahkan pesan sukses
        notyf()->position('x', 'right')->position('y', 'top')->success('Legalisasi berhasil ditambahkan.');
        // Redirect dengan pesan sukses
        return redirect()->route('notary-legalisasi.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(NotaryLegalisasi $notaryLegalisasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $clients = Client::all();
        $data = $this->service->findById($id);
        return view('pages.BackOffice.Legalisasi.form', compact('data', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'applicant_name'    => 'nullable|string|max:255',
            'officer_name'      => 'nullable|string|max:255',
            'document_type'     => 'nullable|string|max:255',
            'document_number'   => 'nullable|string|max:255',
            'request_date'      => 'required|date',
            'release_date'      => 'nullable|date|after_or_equal:request_date',
            'notes'             => 'nullable|string',
            'file_path'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5000', // misal file upload
        ]);

        // Handle file upload jika ada
        if ($request->hasFile('file_path')) {
            $validated['file_path'] = $request->file('file_path')->storeAs('documents', $request->file('file_path')->getClientOriginalName());
        }

        $validated['notaris_id'] = auth()->user()->notaris_id;

        $this->service->update($id, $validated);
        notyf()->position('x', 'right')->position('y', 'top')->success('Legalisasi berhasil diubah.');
        return redirect()->route('notary-legalisasi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->service->delete($id);
        notyf()->position('x', 'right')->position('y', 'top')->success('Legalisasi berhasil dihapus.');
        return redirect()->route('notary-legalisasi.index');
    }
}
