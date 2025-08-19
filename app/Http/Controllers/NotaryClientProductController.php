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

    public function indexDocument(Request $request)
    {
        $filters = $request->only([
            'registration_code',
            'notaris_id',
            'client_id',
            'product_id',
            'status'
        ]);
        $products = $this->notaryClientservice->listDocuments($filters);

        return view('pages.BackOffice.Document.index', compact('products', 'filters'));
    }


    // Detail List Produk Document
    public function detailDocument(Request $request, $registration_code)
    {
        $keys = [
            'registration_code' => $registration_code,
            'notaris_id' => $request->query('notaris_id'),
            'client_id' => $request->query('client_id'),
            'product_id' => $request->query('product_id'),
        ];

        $product = $this->notaryClientservice->getProductByCompositeKey($keys);
        $documents = $this->notaryClientservice->getDocumentHistory($keys);

        return view('pages.BackOffice.Document.document', compact('product', 'documents'));
    }

    // Add Document// Tambah Dokumen
    public function addDocument(Request $request)
    {
        $keys = $request->only(['registration_code', 'notaris_id', 'client_id', 'product_id']);

        $validated = $request->validate([
            'document_code' => 'nullable',
            'document_name' => 'required',
            'document_date' => 'nullable|date',
            'note' => 'nullable|string',
            'document_link' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
            'uploaded_at' => 'nullable|date',
            'status' => 'nullable|string',
        ]);

        // handle file upload kalau ada
        if ($request->hasFile('document_link')) {
            $validated['document_link'] = $request->file('document_link')->storeAs('documents', $request->file('document_link')->getClientOriginalName());
        }

        // status set new
        $validated['status'] = 'new';

        $this->notaryClientservice->addDocument($keys, $validated);
        // dd($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Data berhasil ditambahkan');
        return redirect()->back();
    }



    public function markDones(Request $request)
    {
        $keys = $request->only(['registration_code', 'notaris_id', 'client_id', 'product_id']);
        $this->notaryClientservice->markCompleteds($keys);
        notyf()->position('x', 'right')->position('y', 'top')->success('Status berhasil diubah menjadi done');
        return redirect()->back();
    }

    // Update Status Valid
    public function updateStatusValid(Request $request)
    {
        $keys = $request->only(['registration_code', 'notaris_id', 'client_id', 'product_id']);
        $this->notaryClientservice->updateStatusDocument($keys);
        notyf()->position('x', 'right')->position('y', 'top')->success('Status berhasil diubah menjadi valid');
        return redirect()->back();
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
        // dd($products);
        return view('pages.ManagementProcess.index', compact('products', 'filters'));
    }


    // Detail List Produk Progress
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

    // Add Progress
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

    // Mark Done
    public function markDone(Request $request)
    {
        $keys = $request->only(['registration_code', 'notaris_id', 'client_id', 'product_id']);

        $this->notaryClientservice->markCompleted($keys);

        return redirect()->back()->with('success', 'Status berhasil diubah menjadi done');
    }
}
