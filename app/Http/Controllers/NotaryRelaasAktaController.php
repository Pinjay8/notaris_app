<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Notaris;
use App\Models\NotaryRelaasAkta;
use App\Services\NotaryRelaasAktaService;
use Illuminate\Http\Request;

class NotaryRelaasAktaController extends Controller
{
    protected $service;

    public function __construct(NotaryRelaasAktaService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $perPage = 10;

        if ($request->filled('registration_code')) {
            $data = $this->service->searchByRegistrationCode($request->registration_code, $perPage);
        } elseif ($request->filled('status')) {
            $data = $this->service->filterByStatus($request->status, $perPage);
        } else {
            $data = $this->service->getAll($perPage);
        }

        return view('pages.BackOffice.RelaasAkta.AktaTransaction.index', compact('data'));
    }

    public function create()
    {
        $clients = Client::where('deleted_at', null)->get();
        $notaris = Notaris::where('deleted_at', null)->get();
        return view('pages.BackOffice.RelaasAkta.AktaTransaction.form', compact('clients', 'notaris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'notaris_id' => 'required|exists:notaris,id',
            'client_id' => 'required|exists:clients,id',
            'registration_code' => 'required|string',
            'year' => 'nullable|digits:4|integer',
            'relaas_number' => 'nullable',
            'relaas_number_created_at' => 'nullable',
            'title' => 'required|string',
            'story' => 'required|string',
            'story_date' => 'required|date',
            'story_location' => 'required|string',
            'status' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $this->service->create($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Relaas Akta berhasil ditambahkan.');
        return redirect()->route('relaas-aktas.index');
    }

    public function edit($id)
    {
        $data = $this->service->getById($id);
        $clients = Client::where('deleted_at', null)->get();
        $notaris = Notaris::where('deleted_at', null)->get();

        return view('pages.BackOffice.RelaasAkta.AktaTransaction.form', compact('data', 'clients', 'notaris'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'notaris_id' => 'required|exists:notaris,id',
            'client_id' => 'required|exists:clients,id',
            'registration_code' => 'required|string',
            'year' => 'nullable|digits:4|integer',
            'relaas_number' => 'nullable',
            'relaas_number_created_at' => 'nullable',
            'title' => 'required|string',
            'story' => 'required|string',
            'story_date' => 'required|date',
            'story_location' => 'required|string',
            'status' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $this->service->update($id, $validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Relaas Akta berhasil diperbarui.');
        return redirect()->route('relaas-aktas.index');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect()->route('relaas-aktas.index')->with('success', 'Relaas Akta berhasil dihapus.');
    }


    public function indexNumber(Request $request)
    {

        $lastAkta = NotaryRelaasAkta::orderBy('relaas_number_created_at', 'desc')->first();
        $aktaInfo = null;

        if ($request->filled('search')) {
            $aktaInfo = NotaryRelaasAkta::where('relaas_number', 'like', '%' . $request->search . '%')
                ->orWhere('registration_code', 'like', '%' . $request->search . '%')
                ->first();
        }

        return view('pages.BackOffice.RelaasAkta.AktaNumber.index', compact('lastAkta', 'aktaInfo'));
    }

    public function storeNumber(Request $request)
    {
        $request->validate([
            'relaas_id' => 'required|exists:notary_relaas_aktas,id',
            'relaas_number' => 'required|integer',
            'year' => 'required|digits:4|integer',
        ]);

        $akta = NotaryRelaasAkta::findOrFail($request->relaas_id);

        $akta->update([
            'relaas_number' => $request->relaas_number,
            'year' => $request->year,
            'relaas_number_created_at' => now(),
        ]);

        notyf()->position('x', 'right')->position('y', 'top')->success('Relaas Akta Number berhasil disimpan.');
        return redirect()->route('relaas_akta.indexNumber', [
            'search' => $akta->registration_code, // <-- bawa parameter search
        ]);
    }
}
