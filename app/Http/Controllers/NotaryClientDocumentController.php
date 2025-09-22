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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = NotaryClientDocument::with([
            'client',
            // 'product',
            // 'product.documents', // daftar dokumen yang dibutuhkan
            // 'documentHistory',   // histori dokumen yang sudah diupload
        ]);

        // filter pencarian
        if ($request->filled('registration_code')) {
            $query->where('registration_code', 'like', '%' . $request->registration_code . '%');
        }

        if ($request->filled('client_name')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('fullname', 'like', '%' . $request->client_name . '%');
            });
        }

        $clients = Client::where('deleted_at', null)->get();

        $notarisId = auth()->user()->notaris_id;
        $documents = Documents::where('notaris_id', $notarisId)->get();

        // Misal kita ingin cek dokumen yang belum diupload oleh klien tertentu
        $clientId = $request->client_id ?? null;

        if ($clientId) {
            $uploadedDocCodes = NotaryClientDocument::where('client_id', $clientId)
                ->pluck('document_code')
                ->toArray();

            // Dokumen yang harus diisi (belum diupload)
            $requiredDocuments = $documents->whereNotIn('code', $uploadedDocCodes);
        } else {
            $requiredDocuments = $documents; // semua dokumen ditampilkan
        }

        $products = $query->paginate(10); // pakai paginate biar rapi

        return view('pages.BackOffice.Document.index', [
            'products' => $products,
            'clients'  => $clients,
            'documents' => $documents,
            'requiredDocuments' => $requiredDocuments
        ]);
    }

    public function generateRegistrationCode(int $notarisId, int $clientId): string
    {
        $today = Carbon::now()->format('Ymd');

        // Hitung jumlah konsultasi notaris ini hari ini
        $countToday = NotaryClientDocument::where('notaris_id', $notarisId)
            ->where('client_id', $clientId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $countToday += 1; // untuk konsultasi baru ini

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
            // 'registration_code' => 'required',
            'client_id' => 'required',
            'document_name' => 'required|string',
            'document_code' => 'required|string',
            'document_link' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'note' => 'nullable|string',
        ]);

        // $validated['registration_code'] = $registrationCode;
        // $validated['notaris_id'] = auth()->user()->notaris_id;

        $path = null;
        if ($request->hasFile('document_link')) {
            $path = $request->file('document_link')->storeAS('documents', $request->file('document_link')->getClientOriginalName());
        }

        NotaryClientDocument::create([
            'registration_code' => $registrationCode,
            'client_id' => $request->client_id,
            'notaris_id' => auth()->user()->notaris_id,
            'document_code' => $request->document_code,
            'document_name' => $request->document_name,
            'document_link' => $path,
            'note' => $request->note,
            'status' => 'new',
            'uploaded_at' => $request->uploaded_at ?? now(),
        ]);


        notyf()->position('x', 'right')->position('y', 'top')->success('Data berhasil ditambahkan');
        return back();
    }

    /**
     * Update status dokumen (valid / invalid)
     */
    public function updateStatus(Request $request)
    {
        $request->validate([
            'registration_code' => 'required',
            'client_id' => 'required',
            'status' => 'required|in:valid,invalid',
        ]);

        $doc = NotaryClientDocument::where('registration_code', $request->registration_code)
            ->where('client_id', $request->client_id)
            ->where('document_code', $request->document_code ?? '')
            ->first();

        if ($doc) {
            $doc->status = $request->status;
            $doc->save();
        }

        return back()->with('success', 'Status dokumen berhasil diupdate');
    }

    /**
     * Mark dokumen klien sebagai selesai
     */
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
