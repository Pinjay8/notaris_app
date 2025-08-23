<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\NotaryRelaasAkta;

interface NotaryRelaasAktaRepositoryInterface
{
    public function all(): Collection;
    public function paginate(int $perPage = 10): LengthAwarePaginator;
    public function find(int $id): ?NotaryRelaasAkta;
    public function create(array $data): NotaryRelaasAkta;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;

    // tambahan kebutuhan
    public function searchByRegistrationCode(string $code, int $perPage = 10): LengthAwarePaginator;
    public function filterByStatus(string $status, int $perPage = 10): LengthAwarePaginator;
}
