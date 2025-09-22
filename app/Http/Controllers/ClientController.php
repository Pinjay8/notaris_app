<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Documents;
use App\Models\Notaris;
use App\Models\NotaryClientDocument;
use App\Models\NotaryCost;
use App\Models\NotaryPayment;
use App\Models\PicDocuments;
use App\Models\PicProcess;
use App\Services\ClientService;
// use client request
use DNS2D;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Milon\Barcode\Facades\DNS2DFacade;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function indexClient(Request $request)
    {
        $clients = Client::where('id',)->get();
        return view('pages.Info.index', compact('clients'));
    }

    public function index(Request $request)
    {
        $clients = $this->clientService->search($request->all());
        return view('pages.Client.index', compact('clients'));
    }

    public function create()
    {
        return view('pages.Client.form');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->clientService->create($request->all());
        notyf()->position('x', 'right')->position('y', 'top')->success('Klien berhasil ditambahkan');
        return redirect()->route('clients.index');
    }

    public function edit($id)
    {
        $client = $this->clientService->getById($id);
        return view('pages.Client.form', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $this->clientService->update($id, $request->all());
        notyf()->position('x', 'right')->position('y', 'top')->success('Klien berhasil diperbarui');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->clientService->delete($id);
        notyf()->position('x', 'right')->position('y', 'top')->success('Klien berhasil dihapus');
        return redirect()->back();
    }


    // Share Link

    public function publicForm($encryptedId)
    {
        try {
            $notarisId = Crypt::decrypt($encryptedId);
        } catch (DecryptException $e) {
            abort(404, 'Link tidak valid atau sudah kadaluarsa.');
        }

        // Kirim ke view
        return view('pages.Public.client-form', [
            'notaris_id' => $notarisId
        ]);
    }

    public function editClient($encryptedClientId)
    {
        $clientId = Crypt::decrypt($encryptedClientId);
        $client = Client::findOrFail($clientId);
        return view('pages.Public.client-form', compact('client', 'encryptedClientId'));
    }

    public function updateClient(Request $request, $encryptedClientId)
    {
        // Dekripsi client ID
        try {
            $clientId = Crypt::decrypt($encryptedClientId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(404, 'Link tidak valid.');
        }

        // Cari client
        $client = Client::findOrFail($clientId);

        // Validasi data (bisa pake FormRequest jika ada)
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:clients,nik,' . $client->id,
            'birth_place' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'marital_status' => 'required|string',
            'job' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postcode' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'npwp' => 'nullable|string',
            'type' => 'required|in:personal,company',
            'company_name' => 'nullable|string',
            'note' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        // Update client dengan data valid
        $client->update($validated);

        // Redirect atau response, misalnya kembali ke halaman client dengan pesan sukses
        notyf()->position('x', 'right')->position('y', 'top')->success('Data klien berhasil diperbarui.');
        return redirect()->back();
    }


    public function storeClient(ClientRequest $request,  $encryptedNotarisId)
    {
        try {
            $notaris_id = Crypt::decrypt($encryptedNotarisId);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            abort(403, 'Invalid Notaris ID.');
        }

        $validated = $request->validated();

        $validated['notaris_id'] = $notaris_id;
        $validated['status'] = 'pending';

        Client::create($validated);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil mengirim data klien. Silakan tunggu konfirmasi dari notaris.');
        return redirect()->back();
    }

    public function markAsValid($id)
    {
        $client = Client::findOrFail($id);
        $client->status = 'valid';
        if (empty($client->uuid)) {
            $client->uuid = Str::uuid();
        }
        $client->save();

        notyf()->position('x', 'right')->position('y', 'top')->success('Status Klien Valid atas nama ' . $client->fullname . ' berhasil diubah');
        return redirect()->back();
    }

    public function showQrCode($uuid)
    {
        $client = Client::where('uuid', $uuid)->firstOrFail();

        $link = url("/clients/{$client->uuid}");

        // Generate QR code (format PNG)
        $qrCode = base64_encode(\Milon\Barcode\Facades\DNS2DFacade::getBarcodePNG($link, 'QRCODE', 10, 10));

        return view('pages.Client.modal.qr-code', compact('client', 'link', 'qrCode'));
    }


    public function showByUuid($uuid)
    {
        $client = Client::where('uuid', $uuid)->firstOrFail();

        $notaryCost     = NotaryCost::where('client_id', $client->id)->get();
        $notaryPayment  = NotaryPayment::where('client_id', $client->id)->get();
        $picDocuments   = PicDocuments::with('processes')
            ->where('client_id', $client->id)
            ->get();
        $clientDocuments = NotaryClientDocument::where('client_id', $client->id)->get();

        // Ambil semua dokumen yang belum diupload oleh client
        $uploadedCodes = $clientDocuments->pluck('document_code')->toArray();
        $documents = Documents::where('notaris_id', $client->notaris_id)
            ->whereNotIn('code', $uploadedCodes)
            ->get();

        return view('pages.Client.detail', compact(
            'client',
            'notaryCost',
            'notaryPayment',
            'picDocuments',
            'clientDocuments',
            'documents'
        ));
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


    public function uploadDocument(Request $request, $uuid)
    {
        $client = Client::where('uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'document_code' => 'required|exists:documents,code',
            'document_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'note' => 'nullable|string',
        ]);

        // Ambil data dokumen dari tabel documents
        $document = Documents::where('code', $validated['document_code'])->firstOrFail();

        // Simpan file dengan nama unik
        $fileName = time() . '_' . $request->file('document_file')->getClientOriginalName();
        $filePath = $request->file('document_file')->storeAs('client-documents', $fileName, 'public');

        // Simpan ke notary_client_document
        NotaryClientDocument::create([
            'notaris_id'       => $client->notaris_id,
            'client_id'        => $client->id,
            'registration_code' => $this->generateRegistrationCode($client->notaris_id, $client->id),
            'document_code'    => $document->code,
            'document_name'    => $document->name,
            'note'             => $validated['note'] ?? null,
            'document_link'    => $filePath,
            'uploaded_at'      => now(),
            'status'           => 'new', // default new
        ]);

        return back()->with('success', 'Dokumen berhasil diupload, menunggu validasi admin.');
    }

    // public function showProcessClient($uuid)
    // {
    //     // $client = Client::where('uuid', $uuid)->firstOrFail();
    //     // return view('pages.Client.process', compact('client'));
    //     $client = Client::where('uuid', $uuid)->firstOrFail();
    //     $picDocuments = PicDocuments::where('client_id', $client->id)->get();
    //     $picProcess = PicProcess::where('pic_document_id', $picDocuments->id)->firstOrFail();
    // }

    // public function showCostClient($uuid)
    // {
    //     $client = Client::where('uuid', $uuid)->firstOrFail();
    //     $notaryCost = NotaryCost::where('client_id', $client->id)->get();
    //     return view('pages.Client.detail', compact('client', 'notaryCost'));
    // }
}
