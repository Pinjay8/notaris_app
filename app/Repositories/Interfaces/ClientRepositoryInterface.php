<?php

namespace App\Repositories\Interfaces;

use App\Models\Client;
use Illuminate\Support\Collection;

use Illuminate\Pagination\LengthAwarePaginator;

interface ClientRepositoryInterface
{
    public function all(): Collection;

    public function findById(int $id): ?Client;

    public function getByNotaryId(int $notaryId): Collection;

    public function search(array $filters): LengthAwarePaginator;

    public function create(array $data): Client;

    public function update(int $id, array $data): Client;

    public function delete(int $id): bool;

    public function restore(int $id): bool;

    public function forceDelete(int $id): bool;
}
