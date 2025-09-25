<?php

namespace App\Http\Controllers;

use App\Models\NotaryRelaasAkta;
use App\Models\NotaryRelaasParties;
use App\Services\RelaasPartiesService;
use Illuminate\Http\Request;

class NotaryRelaasPartiesController extends Controller
{
    protected $service;

    public function __construct(RelaasPartiesService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $relaasInfo = null;
        $parties = collect();

        if ($request->has('search')) {
            $relaasInfo = $this->service->searchRelaas($request->search);

            if ($relaasInfo) {
                $parties = $this->service->getParties($relaasInfo->id);
            }
        }

        return view('pages.BackOffice.RelaasAkta.AktaParties.index', compact('relaasInfo', 'parties'));
    }

    public function create($relaasId)
    {
        // relaas untuk header + back-link + action form
        $relaas = NotaryRelaasAkta::select('id', 'registration_code')->findOrFail($relaasId);
        $party  = null;

        return view('pages.BackOffice.RelaasAkta.AktaParties.form', compact('relaas', 'party'));
    }

    public function edit($relaasId, $id)
    {
        $party  = $this->service->findById($id);

        // pastikan relaas mengikuti data party (lebih aman)
        $relaas = NotaryRelaasAkta::select('id', 'registration_code')->findOrFail($party->relaas_id);

        return view('pages.BackOffice.RelaasAkta.AktaParties.form', compact('relaas', 'party'));
    }

    public function store(Request $request, $relaasId)
    {
        $relaas = NotaryRelaasAkta::findOrFail($relaasId);

        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'role'       => 'required|string|max:255',
            'address'    => 'required|string',
            'id_number'  => 'required',
            'id_type'    => 'nullable',
        ], [
            'name.required' => 'Nama harus diisi.',
            'role.required' => 'Peran harus diisi.',
            'address.required' => 'Alamat harus diisi.',
            'id_number.required' => 'Nomor identitas harus diisi.',
        ]);

        $validated['relaas_id'] = $relaas->id;
        $validated['registration_code'] = $relaas->registration_code;
        $validated['client_id'] = $relaas->client_id;
        $validated['notaris_id'] = $relaas->notaris_id;

        $this->service->store($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Pihak Akta berhasil ditambahkan.');

        // pakai registration_code yang dikirim hidden dari form
        return redirect()->route('relaas-parties.index', [
            'search' => $relaas->registration_code
        ]);
    }

    public function update(Request $request, $relaasId, $id)
    {

        $relaas = NotaryRelaasAkta::findOrFail($relaasId);
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'role'       => 'required|string|max:255',
            'address'    => 'nullable|string',
            'id_number'  => 'required',
            'id_type'    => 'nullable',
        ], [
            'name.required' => 'Nama harus diisi.',
            'role.required' => 'Peran harus diisi.',
            'id_number.required' => 'Nomor identitas harus diisi.',
            'id_type.required' => 'Jenis identitas harus diisi.',
        ]);


        $validated['relaas_id'] = $relaas->id;
        $validated['registration_code'] = $relaas->registration_code;
        $validated['client_id'] = $relaas->client_id;
        $validated['notaris_id'] = $relaas->notaris_id;

        $this->service->update($id, $validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Pihak Akta berhasil diperbarui.');

        return redirect()->route('relaas-parties.index', [
            'search' => $relaas->registration_code
        ]);
    }

    public function destroy($id)
    {
        $this->service->destroy($id);

        notyf()->position('x', 'right')->position('y', 'top')->success('Pihak Akta berhasil dihapus.');
        return redirect()->back();
    }
}
