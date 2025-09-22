<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PicDocuments;
use App\Models\PicStaff;
use App\Services\PicDocumentsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

    public function generateRegistrationCode(int $notarisId, int $clientId): string
    {
        $today = Carbon::now()->format('Ymd');

        // Hitung jumlah konsultasi notaris ini hari ini
        $countToday = PicDocuments::where('notaris_id', $notarisId)
            ->where('client_id', $clientId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $countToday += 1; // untuk konsultasi baru ini

        return 'N' . '-' . $today . '-' . $notarisId . '-' . $clientId . '-' . $countToday;
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'pic_id' => 'required',
            'client_id' => 'required',
            'document_type' => 'required',
            'document_number' => 'required',
            'received_date' => 'required',
            'status' => 'required',
            'note' => 'nullable',
        ]);

        $validated['notaris_id'] = auth()->user()->notaris_id;
        $validated['registration_code'] = $this->generateRegistrationCode($validated['notaris_id'], $validated['client_id']);
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
