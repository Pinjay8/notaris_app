<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\NotaryLegalisasi;

interface NotaryLegalisasiRepositoryInterface
{
    public function getAll(array $filters, int $perPage): LengthAwarePaginator;
    public function findById(int $id): ?NotaryLegalisasi;
    public function create(array $data): NotaryLegalisasi;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
