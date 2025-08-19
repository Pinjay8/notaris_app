<?php

namespace App\Repositories;

use App\Models\NotaryAktaParties;
use App\Repositories\Interfaces\NotaryAktaPartiesRepositoryInterface;
use App\Models\NotaryAktaParty;
use Illuminate\Support\Collection;

class NotaryAktaPartiesRepository implements NotaryAktaPartiesRepositoryInterface
{
    public function findByRegistrationCodeOrAktaNumber(string $search): ?Collection
    {
        return NotaryAktaParties::where('registration_code', $search)
            ->orWhereHas(
                'akta_transaction',
                function ($q) use ($search) {
                    $q->where('akta_number', $search);
                }
            )
            ->with('akta_transaction')
            ->get();
    }

    public function getByAktaId(int $aktaId): Collection
    {
        return NotaryAktaParties::where('akta_transaction_id', $aktaId)->get();
    }

    public function create(array $data): NotaryAktaParties
    {
        return NotaryAktaParties::create($data);
    }

    public function update(int $id, array $data): bool
    {
        return NotaryAktaParties::findOrFail($id)->update($data);
    }

    public function delete(int $id): bool
    {
        return NotaryAktaParties::findOrFail($id)->delete();
    }
}
