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

    public function selectClient(Request $request)
    {
        $notarisId = auth()->user()->notaris_id;

        $clients = Client::where('notaris_id', $notarisId)
            ->when($request->search, function ($query, $search) {
                $query->where('fullname', 'like', '%' . $search . '%')->orWhere('client_code', 'like', '%' . $search . '%');
            })
            ->where('deleted_at', null)
            ->withCount('aktaTransactions')
            ->paginate(10);

        return view('pages.BackOffice.AktaTransaction.selectClient', [
            'clients' => $clients,
        ]);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'transaction_code']);
        $transactions = $this->service->list($filters);

        return view('pages.BackOffice.AktaTransaction.index', compact('transactions', 'filters'));
    }

    public function create(Request $request)
    {
        $clientCode = $request->query('client_code');

        $client = Client::where('client_code', $clientCode)->firstOrFail();

        $aktaTypes = NotaryAktaTypes::where('deleted_at', null)->where('notaris_id', auth()->user()->notaris_id)->get();
        return view('pages.BackOffice.AktaTransaction.form', compact('clientCode', 'aktaTypes'));
    }

    // public function generateRegistrationCode(int $notarisId, int $clientId): string
    // {
    //     $today = Carbon::now()->format('Ymd');

    //     // Hitung jumlah konsultasi notaris ini hari ini
    //     $countToday = NotaryAktaTransaction::where('notaris_id', $notarisId)
    //         ->where('client_id', $clientId)
    //         ->whereDate('created_at', Carbon::today())
    //         ->count();

    //     $countToday += 1; // untuk konsultasi baru ini

    //     return 'N' . '-' . $today . '-' . $notarisId . '-' . $clientId . '-' . $countToday;
    // }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
                // 'notaris_id' => 'required|exists:notaris,id',
                // 'registration_code' => 'required|string',
                // 'client_code' => 'required',
                'akta_type_id' => 'required|exists:notary_akta_types,id',
                'date_submission' => 'nullable|date',
                'date_finished' => 'nullable|date',
                'note' => 'nullable|string',
            ],
            [
                // 'client_id.required' => 'Klien harus dipilih.',
                'akta_type_id.required' => 'Jenis akta harus dipilih.',
            ]
        );

        $clientCode = $request->client_code;

        $data['client_code'] = $clientCode;

        $data['transaction_code'] = $clientCode;


        $data['status'] = 'draft';
        $data['year'] = null;
        $data['akta_number'] = null;
        $data['akta_number_created_at'] = null;
        $data['notaris_id'] = auth()->user()->notaris_id;

        $this->service->create($data);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil menambahkan akta transaction.');
        return redirect()->route('akta-transactions.index');
    }

    public function edit($id)
    {
        $transaction = $this->service->get($id);
        $clientCode = $transaction->client_code;
        $aktaTypes = NotaryAktaTypes::where('deleted_at', null)->where('notaris_id', auth()->user()->notaris_id)->get();

        return view('pages.BackOffice.AktaTransaction.form', compact('transaction', 'clientCode', 'aktaTypes'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(
            [
                // 'notaris_id' => 'required|exists:notaris,id',
                // 'registration_code' => 'required|string',
                'client_code' => 'required',
                'akta_type_id' => 'required|exists:notary_akta_types,id',
                'date_submission' => 'required|date',
                'date_finished' => 'required|date',
                'status' => 'required',
                'note' => 'nullable|string',
            ],
            [
                'client_code.required' => 'Klien harus dipilih.',
                'akta_type_id.required' => 'Jenis akta harus dipilih.',
            ]
        );


        // $data['status'] = 'draft';
        // $data['year'] = null;
        // $data['akta_number'] = null;
        // $data['akta_number_created_at'] = null;
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
        $lastAkta = NotaryAktaTransaction::orderBy('created_at', 'desc')->first();
        $aktaInfo = null;

        if ($request->filled('search')) {
            $aktaInfo = NotaryAktaTransaction::query()
                ->where('client_code', $request->search)
                ->orWhere('akta_number', $request->search)
                ->first();

            if (!$aktaInfo) {
                notyf()
                    ->position('x', 'right')
                    ->position('y', 'top')
                    ->error('Kode Klien tidak ditemukan');
            }
        }

        return view('pages.BackOffice.AktaNumber.index', compact('lastAkta', 'aktaInfo'));
    }

    public function storeNumber(Request $request)
    {
        $request->validate([
            'akta_number' => 'required',
            'year' => 'required|integer',
        ]);

        $akta = NotaryAktaTransaction::findOrFail($request->transaction_id);

        // Cek apakah ini edit
        $isEdit = !is_null($akta->akta_number);

        // Update data
        $akta->update([
            'akta_number' => $request->akta_number,
            'year' => $request->year,
            'akta_number_created_at' => now(),
        ]);

        // Alert sesuai kondisi
        if ($isEdit) {
            notyf()->position('x', 'right')->position('y', 'top')
                ->success('Nomor akta berhasil diperbarui.');
        } else {
            notyf()->position('x', 'right')->position('y', 'top')
                ->success('Nomor akta berhasil ditambahkan.');
        }

        return redirect()->route('akta_number.index', ['search' => $akta->client_code]);
    }


    public function updateNumber(Request $request, $id)
    {
        $request->validate(
            [
                'akta_number' => 'required',
                'year' => 'required',
            ],
            [
                'akta_number.required' => 'Nomor akta harus diisi.',
                'year.required' => 'Tahun harus diisi.',
            ]
        );

        $akta = NotaryAktaTransaction::findOrFail($id);
        $akta->update([
            'akta_number' => $request->akta_number,
            'year' => $request->year,
        ]);

        notyf()->position('x', 'right')->position('y', 'top')->success('Nomor akta berhasil diperbarui.');

        return redirect()->route('akta_number.index', ['search' => $akta->client_code]);
    }
}
