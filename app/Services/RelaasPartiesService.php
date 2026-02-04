<?php

namespace App\Services;

use App\Models\NotaryRelaasAkta;
use App\Models\NotaryRelaasParties;
use App\Repositories\Interfaces\RelaasPartiesRepositoryInterface;

class RelaasPartiesService
{
    protected $repo;

    public function __construct(RelaasPartiesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
    public function searchByRegistrationCode(
        ?string $transaction_code,
        ?string $relaas_number
    ): ?object {
        return NotaryRelaasAkta::with(['notaris', 'client'])
            ->where('notaris_id', auth()->user()->notaris_id)
            ->where(function ($q) use ($transaction_code, $relaas_number) {

                if ($transaction_code) {
                    $q->where('transaction_code', $transaction_code);
                }

                if ($relaas_number) {
                    $q->orWhere('relaas_number', $relaas_number);
                }
            })
            ->first();
    }



    public function getParties(int $relaasId)
    {
        return $this->repo->getPartiesByRelaasId($relaasId);
    }

    public function findById($id)
    {
        return NotaryRelaasParties::findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function destroy(int $id)
    {
        return $this->repo->delete($id);
    }
}
