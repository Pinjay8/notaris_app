<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Documents;
use App\Services\DocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentsController extends Controller
{

    public function __construct(protected DocumentService $documentService) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status', '1');

        $documents = $this->documentService->getAll($search, $status);

        return view('pages.Documents.index', compact('documents'));
    }

    public function create()
    {
        return view('pages.Documents.form');
    }

    public function store(DocumentRequest $request)
    {
        $validated = $request->validated();


        try {
            // if ($request->hasFile('image')) {
            //     $validated['image'] = $request->file('image')->storeAs('img', $request->file('image')->getClientOriginalName());
            // }
            $validated['notaris_id'] = auth()->user()->notaris_id;
            $result = $this->documentService->createDocument($validated);


            notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil menambahkan data dokumen');
            return redirect()->route('documents.index');
        } catch (\Exception $e) {
            notyf()->position('x', 'right')->position('y', 'top')->error('Gagal menambahkan data dokumen');
            return redirect()->back()->withInput();
            dd($e->getMessage());
        }
    }

    public function edit($id)
    {
        $document = $this->documentService->findProduct($id);
        return view('pages.Documents.form', compact('document'));
    }

    public function update(DocumentRequest $request, $id)
    {
        $validated = $request->validated();
        $validated['notaris_id'] = auth()->user()->notaris_id;

        // dd($document, $validated);

        Documents::where('id', $id)->update($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil mengubah data dokumen');
        return redirect()->route('documents.index');
    }

    public function deactivate($id)
    {
        try {
            $this->documentService->deactivate($id);
            return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dinonaktifkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
