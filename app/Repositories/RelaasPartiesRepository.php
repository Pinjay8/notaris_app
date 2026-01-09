<?php

namespace App\Repositories;

use App\Models\NotaryRelaasAkta;
use App\Models\NotaryRelaasParties;
use App\Repositories\Interfaces\RelaasPartiesRepositoryInterface;
use Illuminate\Support\Collection;

class RelaasPartiesRepository implements RelaasPartiesRepositoryInterface
{
    public function searchByRegistrationCode(string $transaction_code): ?object
    {
        return NotaryRelaasAkta::with(['notaris', 'client'])
            ->where('transaction_code', $transaction_code)
            ->where('notaris_id', auth()->user()->notaris_id)
            ->first();
    }

    public function getPartiesByRelaasId(int $relaasId)
    {
        return NotaryRelaasParties::where('relaas_id', $relaasId)->where('notaris_id', auth()->user()->notaris_id)
            ->latest()->paginate(10);
    }

    public function create(array $data): object
    {
        return NotaryRelaasParties::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return NotaryRelaasParties::where('id', $id)->update($data) > 0;
    }

    public function delete(int $id): bool
    {
        return NotaryRelaasParties::where('id', $id)->delete() > 0;
    }
}
