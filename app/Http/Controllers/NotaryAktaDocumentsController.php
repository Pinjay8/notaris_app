<?php

namespace App\Http\Controllers;

use App\Models\NotaryAktaDocuments;
use App\Models\NotaryAktaTransaction;
use App\Services\NotaryAktaDocumentService;
use Illuminate\Http\Request;

class NotaryAktaDocumentsController extends Controller
{
    protected $service;

    public function __construct(NotaryAktaDocumentService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['registration_code', 'akta_number']);
        $transaction = null;
        $documents = collect();

        // Cari Akta Transaction dulu
        if (!empty($filters['registration_code']) || !empty($filters['akta_number'])) {
            $transaction = NotaryAktaTransaction::where(function ($q) use ($filters) {
                if (!empty($filters['registration_code'])) {
                    $q->where('registration_code', $filters['registration_code']);
                }
                if (!empty($filters['akta_number'])) {
                    $q->orWhere('akta_number', $filters['akta_number']);
                }
            })->first();

            if ($transaction) {
                $documents = NotaryAktaDocuments::where('akta_transaction_id', $transaction->id)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        return view('pages.BackOffice.AktaDocument.index', compact('transaction', 'documents', 'filters'));
    }


    public function createData($transaction_id)
    {
        $transaction = NotaryAktaTransaction::with('akta_type', 'notaris', 'client')
            ->findOrFail($transaction_id);

        return view('pages.BackOffice.AktaDocument.form', compact('transaction'));
    }

    public function create() {}

    public function store(Request $request) {}


    public function storeData(Request $request, $transaction_id)
    {
        $transaction = NotaryAktaTransaction::findOrFail($transaction_id);

        $data = $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'file_name' => 'required|string',
            'file_url' => 'required|file|max:10240',
            'file_type' => 'required|string',
            'uploaded_at' => 'required|date',
        ]);

        $data['notaris_id'] = $transaction->notaris_id;
        $data['client_id'] = $transaction->client_id;
        $data['akta_transaction_id'] = $transaction->id;
        $data['registration_code'] = $transaction->registration_code;
        $data['akta_number'] = $transaction->akta_number;

        if ($request->hasFile('file_url')) {
            $data['file_url'] = $request->file('file_url')->storeAs('documents', $request->file('file_url')->getClientOriginalName());
        }

        NotaryAktaDocuments::create($data);

        return redirect()->route('akta-documents.index', ['registration_code' => $transaction->registration_code, 'akta_number' => $transaction->akta_number])->with('success', 'Akta Dokumen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $document = $this->service->get($id);
        return view('pages.BackOffice.AktaDocument.form', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'document_name' => 'required|string',
            'file' => 'nullable|file',
            'status' => 'required|in:draft,uploaded,verified'
        ]);

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('akta_documents', 'public');
        }

        $this->service->update($id, $data);

        return redirect()->route('akta-documents.index')->with('success', 'Akta Dokumen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return redirect()->route('akta-documents.index')->with('success', 'AktaDokumen berhasil dihapus.');
    }
}
