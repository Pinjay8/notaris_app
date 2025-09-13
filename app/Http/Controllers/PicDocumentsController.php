<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PicStaff;
use App\Services\PicDocumentsService;
use Illuminate\Http\Request;

class PicDocumentsController extends Controller
{
    protected $service;

    public function __construct(PicDocumentsService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->search,
            'status' => $request->status,
        ];

        $picDocuments = $this->service->getAllDocuments($filters);

        return view('pages.PIC.PicDocuments.index', compact('picDocuments'));
    }

    public function create()
    {
        $clients = Client::all();
        $picStaffList = PicStaff::all();
        return view('pages.PIC.PicDocuments.form', compact('clients', 'picStaffList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pic_id' => 'required',
            'client_id' => 'required',
            'registration_code' => 'required',
            'document_type' => 'required',
            'document_number' => 'required',
            'received_date' => 'required',
            'status' => 'required',
            'note' => 'nullable',
        ]);

        $validated['notaris_id'] = auth()->user()->notaris_id;
        $this->service->createDocument($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('PIC Document berhasil ditambahkan.');
        return redirect()->route('pic_documents.index');
    }

    public function edit($id)
    {
        $clients = Client::all();
        $picStaffList = PicStaff::all();
        $picDocument = $this->service->getDocumentById($id);

        return view('pages.PIC.PicDocuments.form', compact('picDocument', 'clients', 'picStaffList'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'registration_code' => 'required',
            'pic_id' => 'required',
            'client_id' => 'required',
            'received_date' => 'required',
            'document_type' => 'required',
            'document_number' => 'required',
            'status' => 'required',
            'note' => 'nullable',
        ]);

        $validated['notaris_id'] = auth()->user()->notaris_id;

        $this->service->updateDocument($id, $validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('PIC Document berhasil diperbarui.');
        return redirect()->route('pic_documents.index');
    }

    public function destroy($id)
    {
        $this->service->deleteDocument($id);

        notyf()->position('x', 'right')->position('y', 'top')->success('PIC Document berhasil dihapus.');
        return redirect()->route('pic_documents.index');
    }
}
