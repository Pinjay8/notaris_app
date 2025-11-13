<?php

namespace App\Repositories;

use App\Models\NotaryRelaasAkta;
use App\Models\NotaryRelaasParties;
use App\Repositories\Interfaces\RelaasPartiesRepositoryInterface;
use Illuminate\Support\Collection;

class RelaasPartiesRepository implements RelaasPartiesRepositoryInterface
{
    public function searchByRegistrationCode(string $client_code): ?object
    {
        return NotaryRelaasAkta::with(['notaris', 'client'])
            ->where('client_code', $client_code)
            ->first();
    }

    public function getPartiesByRelaasId(int $relaasId): Collection
    {
        return NotaryRelaasParties::where('relaas_id', $relaasId)->get();
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
