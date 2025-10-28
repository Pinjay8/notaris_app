<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Documents;
use App\Models\NotaryClientDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use League\CommonMark\Node\Block\Document;

class NotaryClientDocumentController extends Controller
{
    public function index(Request $request)
    {
        $query = NotaryClientDocument::with('client');
        if ($request->filled('registration_code')) {
            $query->where('registration_code', 'like', '%' . $request->registration_code . '%');
        }

        if ($request->filled('client_name')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('fullname', 'like', '%' . $request->client_name . '%');
            });
        }

        $notarisId = auth()->user()->notaris_id;

        $documents = $query->where('notaris_id', $notarisId)->orderBy('created_at', 'desc')->paginate(10);
        $clients = Client::where('notaris_id', $notarisId)->get();

        return view('pages.BackOffice.Document.index', [
            'documents' => $documents,
            'clients' => $clients,
        ]);
    }

    public function create()
    {
        $notarisId = auth()->user()->notaris_id;

        $clients = Client::where('notaris_id', $notarisId)->get();
        $documents = Documents::where('notaris_id', $notarisId)->get();

        return view('pages.BackOffice.Document.form', [
            'clients' => $clients,
            'documents' => $documents,
        ]);
    }

    public function generateRegistrationCode(int $notarisId, int $clientId): string
    {
        $today = Carbon::now()->format('Ymd');

        $countToday = NotaryClientDocument::where('notaris_id', $notarisId)
            ->where('client_id', $clientId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $countToday += 1;

        return 'N' . '-' . $today . '-' . $notarisId . '-' . $clientId . '-' . $countToday;
    }


    public function addDocument(Request $request)
    {

        $notarisId = auth()->user()->notaris_id;

        $clients = Client::where('notaris_id', $notarisId)->get();
        $firstClient = $clients->first();

        $registrationCode = $firstClient
            ? $this->generateRegistrationCode($notarisId, $firstClient->id)
            : null;

        $validated = $request->validate([
            'client_id' => 'required',
            'document_code' => 'required|string',
            'document_link' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'note' => 'nullable|string',
        ]);

        $document = Documents::where('code', $validated['document_code'])
            ->where('notaris_id', $notarisId)
            ->firstOrFail();

        $path = null;
        if ($request->hasFile('document_link')) {
            $path = $request->file('document_link')
                ->storeAs('documents', $request->file('document_link')->getClientOriginalName());
        }

        NotaryClientDocument::create([
            'registration_code' => $registrationCode,
            'client_id' => $request->client_id,
            'notaris_id' => $notarisId,
            'document_code' => $document->code,
            'document_name' => $document->name,
            'document_link' => $path,
            'note' => $request->note,
            'status' => 'new',
            'uploaded_at' => now(),
        ]);

        notyf()->position('x', 'right')->position('y', 'top')->success('Data berhasil ditambahkan');
        return back();
    }


    public function updateStatus(Request $request)
    {
        $request->validate([
            'registration_code' => 'required',
            'client_id' => 'required',
            'status' => 'required|in:valid,invalid',
        ]);

        $clientDoc = NotaryClientDocument::where('registration_code', $request->registration_code)
            ->where('client_id', $request->client_id)
            ->first();

        if ($clientDoc) {
            $clientDoc->status = $request->status;
            $clientDoc->save();
        }

        $msg = $request->status === 'valid'
            ? 'Dokumen berhasil divalidasi'
            : 'Dokumen ditandai tidak valid';

        notyf()->position('x', 'right')->position('y', 'top')->success($msg);
        return back();
    }

    public function store(Request $request)
    {
        $notarisId = auth()->user()->notaris_id;

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'document_code' => 'required|string|exists:documents,code',
            'document_link' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'note' => 'nullable|string|max:500',
            'uploaded_at' => 'required|date',
        ], [
            'client_id.exists' => 'Klien harus dipilih.',
            'document_code.exists' => 'Dokumen harus dipilih.',
        ]);

        $document = Documents::where('code', $validated['document_code'])
            ->where('notaris_id', $notarisId)
            ->firstOrFail();

        $path = null;
        if ($request->hasFile('document_link')) {
            $path = $request->file('document_link')
                ->storeAs('documents', $request->file('document_link')->getClientOriginalName());
        }

        NotaryClientDocument::create([
            'registration_code' => $this->generateRegistrationCode($notarisId, $validated['client_id']),
            'client_id' => $validated['client_id'],
            'notaris_id' => $notarisId,
            'document_code' => $document->code,
            'document_name' => $document->name,
            'document_link' => $path,
            'note' => $validated['note'],
            'status' => 'new',
            'uploaded_at' => $validated['uploaded_at'],
        ]);

        notyf()->position('x', 'right')->position('y', 'top')->success('Dokumen berhasil ditambahkan');
        return redirect()->route('management-document.index');
    }

    public function update(Request $request, NotaryClientDocument $document)
    {
        $notarisId = auth()->user()->notaris_id;

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'document_code' => 'required|string|exists:documents,code',
            'document_link' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'note' => 'nullable|string|max:500',
            'uploaded_at' => 'required|date',
        ]);

        $docModel = Documents::where('code', $validated['document_code'])
            ->where('notaris_id', $notarisId)
            ->firstOrFail();

        if ($request->hasFile('document_link')) {
            $path = $request->file('document_link')
                ->storeAs('documents', $request->file('document_link')->getClientOriginalName());
            $document->document_link = $path;
        }

        $document->update([
            'client_id' => $validated['client_id'],
            'document_code' => $docModel->code,
            'document_name' => $docModel->name,
            'note' => $validated['note'],
            'uploaded_at' => $validated['uploaded_at'],
        ]);

        notyf()->success('Dokumen berhasil diperbarui');
        return redirect()->route('documents.index');
    }

    public function markDone(Request $request)
    {
        $request->validate([
            'registration_code' => 'required',
            'client_id' => 'required',
        ]);

        $clientDoc = NotaryClientDocument::where('registration_code', $request->registration_code)
            ->where('client_id', $request->client_id)
            ->first();

        if ($clientDoc) {
            $clientDoc->status = 'valid';
            $clientDoc->save();
        }

        notyf()->position('x', 'right')->position('y', 'top')->success('Status dokumen berhasil diubah menjadi done');
        return back();
    }
}
