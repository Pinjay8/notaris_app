<?php

namespace App\Http\Controllers;

use App\Models\NotaryAktaTransaction;
use App\Services\NotaryAktaPartyService;
use Illuminate\Http\Request;

class NotaryAktaPartiesController extends Controller
{
    protected $service;

    public function __construct(NotaryAktaPartyService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $parties = [];
        $aktaInfo = null;

        if ($request->filled('search')) {
            $aktaInfo = $this->service->searchAkta($request->search);

            if ($aktaInfo && $aktaInfo->count() > 0) {
                $aktaTransactionId = $aktaInfo->first()->id; // pakai id, bukan akta_transaction_id

                if (!empty($aktaTransactionId)) {
                    $parties = $this->service->getPartiesByAkta($aktaTransactionId);
                }
            }
        }
        return view('pages.BackOffice.AktaParties.index', compact('aktaInfo', 'parties'));
    }

    public function createData($akta_transaction_id)
    {
        $transaction = NotaryAktaTransaction::with('akta_type', 'notaris', 'client')
            ->findOrFail($akta_transaction_id);

        return view('pages.BackOffice.AktaParties.form', [
            'transaction' => $transaction,
            'aktaParty' => null // supaya form bisa bedakan create / edit
        ]);
    }
    public function storeData(Request $request)
    {
        $request->validate([
            'registration_code' => 'required',
            'name' => 'required|string',
            'role' => 'required|string',
            'address' => 'required|string',
            'id_number' => 'required|string',
            'id_type' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $this->service->store($request->all());

        notyf()->position('x', 'right')->position('y', 'top')->success('Pihak berhasil ditambahkan.');
        return redirect()->route('akta-parties.index', ['search' => $request->registration_code]);
    }

    public function edit($id)
    {
        // $aktaParty = $this->service->getPartiesByAkta($id); // misal service ada method find
        // $transaction = $aktaParty->transaction; // relasi ke NotaryAktaTransaction
        $aktaParty = $this->service->findParty($id);
        $transaction = $aktaParty->akta_transaction; // relasi belongsTo

        return view('pages.BackOffice.AktaParties.form', compact('transaction', 'aktaParty'));
    }

    public function update(Request $request, $id)
    {
        $this->service->updateParty($id, $request->all());

        notyf()->position('x', 'right')->position('y', 'top')->success('Pihak berhasil diperbarui.');
        return redirect()->route('akta-parties.index', ['search' => $request->registration_code]);
    }

    public function destroy($id)
    {
        $this->service->deleteParty($id);
        return back()->with('success', 'Pihak berhasil dihapus.');
    }
}
