<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Notaris;
use App\Models\NotaryAktaTransaction;
use App\Services\NotaryAktaLogService;
use Illuminate\Http\Request;

class NotaryAktaLogsController extends Controller
{
    protected $service;

    public function __construct(NotaryAktaLogService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['registration_code', 'step']);
        $logs = $this->service->list($filters);

        return view('pages.BackOffice.AktaLogs.index', compact('logs', 'filters'));
    }

    public function create()
    {
        $notaris = Notaris::all();
        $clients = Client::all();
        $transactions = NotaryAktaTransaction::all();
        return view('pages.BackOffice.AktaLogs.form', compact('notaris', 'clients', 'transactions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'notaris_id' => 'required|exists:notaris,id',
            'client_id' => 'required|exists:clients,id',
            'akta_transaction_id' => 'required|exists:notary_akta_transactions,id',
            'registration_code' => 'nullable|string',
            'step' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $this->service->create($data);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil menambahkan log.');
        return redirect()->route('akta-logs.index');
    }

    public function edit($id)
    {
        $log = $this->service->get($id);
        $notaris = Notaris::all();
        $clients = Client::all();
        $transactions = NotaryAktaTransaction::all();
        return view('pages.BackOffice.AktaLogs.form', compact('log', 'notaris', 'clients', 'transactions'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'notaris_id' => 'required|exists:notaris,id',
            'client_id' => 'required|exists:clients,id',
            'akta_transaction_id' => 'required|exists:notary_akta_transactions,id',
            'registration_code' => 'nullable|string',
            'step' => 'required|string',
            'note' => 'nullable|string',
        ]);

        $this->service->update($id, $data);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil memperbarui log.');

        return redirect()->route('akta-logs.index');
    }

    public function destroy($id)
    {
        $this->service->delete($id);

        notyf()->position('x', 'right')->position('y', 'top')->success('Berhasil menghapus log.');
        return redirect()->route('akta-logs.index');
    }
}
