<?php

namespace App\Services;

use App\Models\NotaryAktaParties;
use App\Models\NotaryAktaTransaction;
use App\Repositories\Interfaces\NotaryAktaPartiesRepositoryInterface;

class NotaryAktaPartyService
{
    protected $repo;

    public function __construct(NotaryAktaPartiesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function searchAkta(string $search)
    {
        return NotaryAktaTransaction::query()
            ->where('registration_code', $search)
            ->orWhere('akta_number', $search)
            ->get();
    }
    public function findParty(int $id)
    {
        return NotaryAktaParties::findOrFail($id);
    }

    public function getPartiesByAkta($aktaTransactionId)
    {
        return NotaryAktaParties::where('akta_transaction_id', $aktaTransactionId)->get();
    }

    public function addParty(array $data)
    {
        return $this->repo->create($data);
    }

    public function store(array $data)
    {
        // Cari akta transaksi berdasarkan registration_code
        $akta = NotaryAktaTransaction::where('registration_code', $data['registration_code'])->firstOrFail();

        $data['akta_transaction_id'] = $akta->id;
        $data['notaris_id'] = $akta->notaris_id;
        $data['client_id'] = $akta->client_id;

        return $this->repo->create($data);
    }

    public function updateParty(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function deleteParty(int $id)
    {
        return $this->repo->delete($id);
    }
}
