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

    // public function selectClient(Request $request)
    // {
    //     $notarisId = auth()->user()->notaris_id;
    //     $clients = Client::where('notaris_id', $notarisId)->paginate(10);
    //     return view('pages.BackOffice.Warkah.selectClient', [
    //         'clients' => $clients,
    //     ]);
    // }

    public function selectClient(Request $request)
    {
        $notarisId = auth()->user()->notaris_id;

        $clients = Client::where('notaris_id', $notarisId)
            ->when($request->search, function ($query, $search) {
                $query->where('fullname', 'like', '%' . $search . '%')->orWhere('client_code', 'like', '%' . $search . '%');
            })
            ->where('deleted_at', null)
            ->paginate(10);

        return view('pages.BackOffice.Warkah.selectClient', [
            'clients' => $clients,
        ]);
    }

    public function index(Request $request, $clientId)
    {
        $client = Client::findOrFail($clientId);
        $query = NotaryClientWarkah::with('client');
        if ($request->filled('client_code')) {
            $query->where('client_code', 'like', '%' . $request->client_code . '%');
        }

        if ($request->filled('fullname')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('fullname', 'like', '%' . $request->client_name . '%');
            });
        }

        $notarisId = auth()->user()->notaris_id;

        $documents = $query->where('notaris_id', $notarisId)->where('client_code', $client->client_code)->where('client_code', $client->client_code)->orderBy('created_at', 'desc')->paginate(10);
        $clients = Client::where('notaris_id', $notarisId)->get();

        return view('pages.BackOffice.Warkah.index', [
            'clients' => $clients,
            'documents' => $documents,
            'client' => $client
        ]);
    }
    // public function index(Request $request)
    // {
    //     $query = NotaryClientWarkah::with('client');
    //     if ($request->filled('client_code')) {
    //         $query->where('client_code', 'like', '%' . $request->client_code . '%');
    //     }

    //     if ($request->filled('client_name')) {
    //         $query->whereHas('client', function ($q) use ($request) {
    //             $q->where('fullname', 'like', '%' . $request->client_name . '%');
    //         });
    //     }

    //     $notarisId = auth()->user()->notaris_id;

    //     $documents = $query->where('notaris_id', $notarisId)->orderBy('created_at', 'desc')->paginate(10);
    //     $clients = Client::where('notaris_id', $notarisId)->get();

    //     return view('pages.BackOffice.Warkah.index', [
    //         'clients' => $clients,
    //         'documents' => $documents,
    //     ]);
    // }

    // public function create(Request $request)
    // {
    //     $notarisId = auth()->user()->notaris_id;

    //     $clients = Client::where('notaris_id', $notarisId)->get();
    //     $documents = Documents::where('notaris_id', $notarisId)->get();
    //     $client = Client::findOrFail($request->client_id);

    //     return view('pages.BackOffice.Warkah.form', [
    //         'clients' => $clients,
    //         'documents' => $documents,
    //         'client' => $client
    //     ]);
    // }


    public function create($id)
    {
        $notarisId = auth()->user()->notaris_id;

        // Cari client berdasarkan ID dari URL
        $client = Client::where('notaris_id', $notarisId)
            ->where('id', $id)
            ->firstOrFail();

        $documents = Documents::where('notaris_id', $notarisId)->get();

        return view('pages.BackOffice.Warkah.form', [
            'documents' => $documents,
            'client' => $client
        ]);
    }

    // public function generateRegistrationCode(int $notarisId, int $clientId): string
    // {
    //     $today = Carbon::now()->format('Ymd');

    //     $countToday = NotaryClientWarkah::where('notaris_id', $notarisId)
    //         ->where('client_id', $clientId)
    //         ->whereDate('created_at', Carbon::today())
    //         ->count();

    //     $countToday += 1;

    //     return 'N' . '-' . $today . '-' . $notarisId . '-' . $clientId . '-' . $countToday;
    // }


    // public function addDocument(Request $request)
    // {
    //     $notarisId = auth()->user()->notaris_id;

    //     $clients = Client::where('notaris_id', $notarisId)->get();
    //     $firstClient = $clients->first();

    //     $registrationCode = $firstClient
    //         ? $this->generateRegistrationCode($notarisId, $firstClient->id)
    //         : null;

    //     $validated = $request->validate([
    //         'client_id' => 'required',
    //         'warkah_code' => 'required|string',
    //         'warkah_link' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    //         'note' => 'nullable|string',
    //     ]);

    //     $document = Documents::where('code', $validated['warkah_code'])
    //         ->where('notaris_id', $notarisId)
    //         ->firstOrFail();

    //     $path = null;
    //     if ($request->hasFile('warkah_link')) {
    //         $path = $request->file('warkah_link')
    //             ->storeAs('documents', $request->file('warkah_link')->getClientOriginalName());
    //     }

    //     NotaryClientWarkah::create([
    //         'registration_code' => $registrationCode,
    //         'client_id' => $request->client_id,
    //         'notaris_id' => $notarisId,
    //         'warkah_code' => $document->code,
    //         'warkah_name' => $document->name,
    //         'warkah_link' => $path,
    //         'note' => $request->note,
    //         'status' => 'new',
    //         'uploaded_at' => now(),
    //     ]);


    //     notyf()->position('x', 'right')->position('y', 'top')->success('Data warkah berhasil ditambahkan');
    //     return back();
    // }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'client_code' => 'required',
            'status' => 'required|in:valid,invalid',
        ]);

        $warkah  = NotaryClientWarkah::findOrFail($id);

        $warkah->update([
            'status' => $request->status,
        ]);

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
            'client_code' => 'required',
            'warkah_code' => 'required',
            'warkah_link' => 'nullable|mimes:jpg,jpeg,png,pdf|max:1024',
            'note' => 'nullable',
            'uploaded_at' => 'required|date',
        ], [
            'client_code.required' => 'Klien harus dipilih.',
            'warkah_code.required' => 'Dokumen harus dipilih.',
            'warkah_link.required' => 'File warkah harus diupload.',
            'warkah_link.max' => 'Ukuran file maksimal 1MB.',
            'warkah_link.mimes' => 'Format file harus JPG, JPEG, PNG, atau PDF.',
        ]);

        $document = Documents::where('code', $validated['warkah_code'])
            ->where('notaris_id', $notarisId)
            ->firstOrFail();

        $path = null;
        if ($request->hasFile('warkah_link')) {
            $path = $request->file('warkah_link')
                ->storeAs('documents', $request->file('warkah_link')->getClientOriginalName());
        }

        $client = Client::where('client_code', $request->client_code)->firstOrFail();

        NotaryClientWarkah::create([
            'client_code' => $validated['client_code'],
            'notaris_id' => $notarisId,
            'warkah_code' => $document->code,
            'warkah_name' => $document->name,
            'warkah_link' => $path,
            'note' => $validated['note'],
            'status' => 'new',
            'uploaded_at' => $validated['uploaded_at'],
        ]);

        notyf()->position('x', 'right')->position('y', 'top')->success('Warkah berhasil ditambahkan');
        return redirect()->route('warkah.index', ['id' => $client->id]);
    }
}
