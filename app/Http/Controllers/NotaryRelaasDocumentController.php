<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\NotaryRelaasAkta;
use App\Models\NotaryRelaasDocument;
use App\Services\NotaryRelaasDocumentService;
use Illuminate\Http\Request;

class NotaryRelaasDocumentController extends Controller
{
    protected $service;

    public function __construct(NotaryRelaasDocumentService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $relaasInfo = null;
        $documents = collect();

        if ($request->has('search')) {
            $relaasInfo = $this->service->searchRelaas($request->search); // search by registration_code atau relaas_number

            if ($relaasInfo) {
                $documents = $this->service->getDocuments($relaasInfo->id);
            }
        }

        return view('pages.BackOffice.RelaasAkta.AktaDocument.index', compact('relaasInfo', 'documents'));
    }

    public function create($relaasId)
    {
        $relaas = NotaryRelaasAkta::findOrFail($relaasId);
        $doc = null;
        $clients = Client::where('deleted_at', null)->get();

        return view('pages.BackOffice.RelaasAkta.AktaDocument.form', compact('relaas', 'doc', 'clients'));
    }

    public function edit($relaasId, $id)
    {
        $doc = $this->service->findById($id);
        $relaas = NotaryRelaasAkta::findOrFail($doc->relaas_id);
        $clients = Client::where('deleted_at', null)->get();

        return view('pages.BackOffice.RelaasAkta.AktaDocument.form', compact('relaas', 'doc', 'clients'));
    }

    public function store(Request $request, $relaasId)
    {
        $relaas = NotaryRelaasAkta::findOrFail($relaasId);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'type'      => 'required|string|max:255',
            'uploaded_at' => 'required|date',
        ], [
            'name.required' => 'Nama dokumen harus diisi.',
            'type.required' => 'Tipe dokumen harus diisi.',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_url']  = $file->storeAs('documents', $file->getClientOriginalName());
            $validated['file_type'] = $file->getClientMimeType();
        }

        $validated['relaas_id'] = $relaas->id;
        // $validated['registration_code'] = $relaas->registration_code;
        $validated['notaris_id'] = $relaas->notaris_id;
        $validated['client_code'] = $relaas->client_code;
        // $validated['uploaded_at'] = now();

        $this->service->store($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Dokumen akta berhasil ditambahkan.');

        return redirect()->route('relaas-documents.index', ['search' => $relaas->registration_code]);
    }

    public function update(Request $request, $relaasId, $id)
    {
        $relaas = NotaryRelaasAkta::findOrFail($relaasId);

        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'type'      => 'required|string|max:255',
        ], [
            'name.required' => 'Nama dokumen harus diisi.',
            'type.required' => 'Jenis dokumen harus diisi.',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_url']  = $file->store('relaas_documents', 'public');
            $validated['file_type'] = $file->getClientMimeType();
        }

        $validated['relaas_id'] = $relaas->id;
        // $validated['registration_code'] = $relaas->registration_code;
        $validated['notaris_id'] = $relaas->notaris_id;
        $validated['client_code'] = $relaas->client_code;

        $this->service->update($id, $validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Dokumen akta berhasil diperbarui.');

        return redirect()->route('relaas-documents.index', ['search' => $relaas->client_code]);
    }

    public function destroy($id)
    {
        $this->service->destroy($id);

        notyf()->position('x', 'right')->position('y', 'top')->success('Dokumen akta berhasil dihapus.');
        return redirect()->back();
    }

    public function toggleStatus($id)
    {
        $this->service->toggleStatus($id);

        notyf()->position('x', 'right')->position('y', 'top')->success('Status dokumen berhasil diperbarui.');
        return redirect()->back();
    }
}
