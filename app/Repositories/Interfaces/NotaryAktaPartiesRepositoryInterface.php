<?php

namespace App\Repositories\Interfaces;

use App\Models\NotaryAktaParties;
use Illuminate\Support\Collection;
use App\Models\NotaryAktaParty;

interface NotaryAktaPartiesRepositoryInterface
{
    public function findByRegistrationCodeOrAktaNumber(string $search): ?Collection;
    public function getByAktaId(int $aktaId): Collection;
    public function create(array $data): NotaryAktaParties;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
