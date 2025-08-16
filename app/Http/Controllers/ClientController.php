<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Notaris;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Str;
use Milon\Barcode\Facades\DNS2DFacade;
use DNS2D;
// use client request
use App\Http\Requests\ClientRequest;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
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
        return view('pages.Client.detail', compact('client'));
    }
}
