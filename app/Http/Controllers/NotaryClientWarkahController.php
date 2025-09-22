<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Documents;
use App\Models\NotaryClientWarkah;
use App\Services\NotaryClientService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotaryClientWarkahController extends Controller
{

    // protected $notaryClientservice;


    // public function __construct(NotaryClientService $notaryClientservice)
    // {
    //     $this->notaryClientservice = $notaryClientservice;
    // }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $filters = $request->only([
        //     'registration_code',
        //     'notaris_id',
        //     'client_id',
        //     'product_id',
        //     'status'
        // ]);
        // $products = $this->notaryClientservice->listWarkah($filters);

        $query = NotaryClientWarkah::with([
            'client',
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
            $uploadedDocCodes = NotaryClientWarkah::where('client_id', $clientId)
                ->pluck('warkah_code')
                ->toArray();

            // Dokumen yang harus diisi (belum diupload)
            $requiredDocuments = $documents->whereNotIn('code', $uploadedDocCodes);
        } else {
            $requiredDocuments = $documents; // semua dokumen ditampilkan
        }

        $products = $query->paginate(10); // pakai paginate biar rapi

        return view('pages.BackOffice.Warkah.index', [
            'products' => $products,
            'clients'  => $clients,
            'documents' => $documents,
            'requiredDocuments' => $requiredDocuments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function generateRegistrationCode(int $notarisId, int $clientId): string
    {
        $today = Carbon::now()->format('Ymd');

        // Hitung jumlah konsultasi notaris ini hari ini
        $countToday = NotaryClientWarkah::where('notaris_id', $notarisId)
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
            'client_id' => 'required',
            'warkah_code' => 'required|string',
            'warkah_link' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'note' => 'nullable|string',
        ]);

        // Cari document_name dari tabel documents
        $document = Documents::where('code', $validated['warkah_code'])
            ->where('notaris_id', $notarisId)
            ->firstOrFail();

        $path = null;
        if ($request->hasFile('warkah_link')) {
            $path = $request->file('warkah_link')
                ->storeAs('documents', $request->file('warkah_link')->getClientOriginalName());
        }

        NotaryClientWarkah::create([
            'registration_code' => $registrationCode,
            'client_id' => $request->client_id,
            'notaris_id' => $notarisId,
            'warkah_code' => $document->code,
            'warkah_name' => $document->name, // ambil dari table documents
            'warkah_link' => $path,
            'note' => $request->note,
            'status' => 'new',
            'uploaded_at' => now(),
        ]);

        // dd($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Data warkah berhasil ditambahkan');
        return back();
    }


    /**
     * Update status dokumen (valid / invalid)
     */ public function updateStatus(Request $request)
    {
        $request->validate([
            'registration_code' => 'required',
            'client_id' => 'required',
            'status' => 'required|in:valid,invalid', // hanya boleh valid atau invalid
        ]);

        $clientDoc = NotaryClientWarkah::where('registration_code', $request->registration_code)
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




    // public function markDones(Request $request)
    // {
    //     $keys = $request->only(['registration_code', 'notaris_id', 'client_id', 'product_id']);
    //     $this->notaryClientservice->markCompleteds($keys);
    //     notyf()->position('x', 'right')->position('y', 'top')->success('Status berhasil diubah menjadi done');
    //     return redirect()->back();
    // }

    // public function updateStatusValid(Request $request)
    // {
    //     $keys = $request->only(['registration_code', 'notaris_id', 'client_id', 'product_id']);
    //     $this->notaryClientservice->updateStatusWarkah($keys);
    //     notyf()->position('x', 'right')->position('y', 'top')->success('Status berhasil diubah menjadi valid');
    //     return redirect()->back();
    // }
}
