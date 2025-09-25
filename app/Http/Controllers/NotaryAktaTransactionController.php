<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Notaris;
use App\Models\NotaryAktaTransaction;
use App\Models\NotaryAktaType;
use App\Models\NotaryAktaTypes;
use App\Services\NotaryAktaTransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NotaryAktaTransactionController extends Controller
{
    protected $service;

    public function __construct(NotaryAktaTransactionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'registration_code']);
        $transactions = $this->service->list($filters);

        return view('pages.BackOffice.AktaTransaction.index', compact('transactions', 'filters'));
    }

    public function create()
    {
        $clients = Client::all();
        $aktaTypes = NotaryAktaTypes::all(); // hanya yang aktif jika soft delete
        $notaris = Notaris::whereNull('deleted_at')->get();
        return view('pages.BackOffice.AktaTransaction.form', compact('clients', 'aktaTypes', 'notaris'));
    }

    public function generateRegistrationCode(int $notarisId, int $clientId): string
    {
        $today = Carbon::now()->format('Ymd');

        // Hitung jumlah konsultasi notaris ini hari ini
        $countToday = NotaryAktaTransaction::where('notaris_id', $notarisId)
            ->where('client_id', $clientId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $countToday += 1; // untuk konsultasi baru ini

        return 'N' . '-' . $today . '-' . $notarisId . '-' . $clientId . '-' . $countToday;
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
                // 'notaris_id' => 'required|exists:notaris,id',
                // 'registration_code' => 'required|string',
                'client_id' => 'required|exists:clients,id',
                'akta_type_id' => 'required|exists:notary_akta_types,id',
                'date_submission' => 'nullable|date',
                'date_finished' => 'nullable|date',
                'note' => 'nullable|string',
            ],
            [
                'client_id.required' => 'Klien harus dipilih.',
                'akta_type_id.required' => 'Jenis akta harus dipilih.',
            ]
        );

        $data['status'] = 'draft';
        $data['year'] = null;
        $data['akta_number'] = null;
        $data['akta_number_created_at'] = null;
        $data['notaris_id'] = auth()->user()->notaris_id;
        $data['registration_code'] = $this->generateRegistrationCode($data['notaris_id'], $data['client_id']);

        $this->service->create($data);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil menambahkan akta transaction.');
        return redirect()->route('akta-transactions.index');
    }

    public function edit($id)
    {
        $transaction = $this->service->get($id);
        $clients = Client::all();
        $aktaTypes = NotaryAktaTypes::all();
        $notaris = Notaris::whereNull('deleted_at')->get();

        return view('pages.BackOffice.AktaTransaction.form', compact('transaction', 'clients', 'aktaTypes', 'notaris'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(
            [
                // 'notaris_id' => 'required|exists:notaris,id',
                // 'registration_code' => 'required|string',
                'client_id' => 'required|exists:clients,id',
                'akta_type_id' => 'required|exists:notary_akta_types,id',
                'date_submission' => 'required|date',
                'date_finished' => 'required|date',
                'note' => 'nullable|string',
            ],
            [
                'client_id.required' => 'Klien harus dipilih.',
                'akta_type_id.required' => 'Jenis akta harus dipilih.',
            ]
        );


        $data['status'] = 'draft';
        $data['year'] = null;
        $data['akta_number'] = null;
        $data['akta_number_created_at'] = null;
        $data['notaris_id'] = auth()->user()->notaris_id;

        $this->service->update($id, $data);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil memperbarui akta transaction.');
        return redirect()->route('akta-transactions.index');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil menghapus akta transaction.');
        return redirect()->route('akta-transactions.index');
    }


    // Penomoran Akta
    public function indexNumber(Request $request)
    {
        $lastAkta = NotaryAktaTransaction::orderBy('akta_number_created_at', 'desc')->first();
        $aktaInfo = null;

        if ($request->filled('search')) {
            $aktaInfo = NotaryAktaTransaction::query()
                ->where('registration_code', $request->search)
                ->orWhere('akta_number', $request->search)
                ->first();
        }

        return view('pages.BackOffice.AktaNumber.index', compact('lastAkta', 'aktaInfo'));
    }

    public function storeNumber(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:notary_akta_transactions,id',
            'akta_number' => 'required|string|unique:notary_akta_transactions,akta_number',
            'year' => 'required|integer',
        ]);

        $akta = NotaryAktaTransaction::findOrFail($request->transaction_id);

        $akta->update([
            'akta_number' => $request->akta_number,
            'year' => $request->year,
            'akta_number_created_at' => now(),
        ]);

        notyf()->position('x', 'right')->position('y', 'top')->success('Nomor akta berhasil ditambahkan.');
        return redirect()->route('akta_number.index');
    }


    public function updateNumber(Request $request, $id)
    {
        $request->validate([
            'akta_number' => 'required|string|unique:notary_akta_transactions,akta_number,' . $id,
            'year' => 'required|integer',
        ]);

        $akta = NotaryAktaTransaction::findOrFail($id);
        $akta->update([
            'akta_number' => $request->akta_number,
            'year' => $request->year,
        ]);

        return redirect()->route('akta_number.index')->with('success', 'Nomor akta berhasil diupdate.');
    }
}
