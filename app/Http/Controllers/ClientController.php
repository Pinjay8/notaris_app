<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Notaris;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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
        return redirect()->route('clients.index')
            ->with('success', 'Klien berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $client = $this->clientService->getById($id);
        return view('pages.Client.form', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $this->clientService->update($id, $request->all());
        return redirect()->back()->with('success', 'Klien berhasil diperbarui');
    }

    public function destroy($id)
    {
        $this->clientService->delete($id);
        return redirect()->back()->with('success', 'Klien berhasil dihapus');
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
    public function storeClient(Request $request,  $encryptedNotarisId)
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
}
