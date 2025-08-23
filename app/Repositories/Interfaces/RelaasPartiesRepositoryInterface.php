<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface RelaasPartiesRepositoryInterface
{
    public function searchByRegistrationCode(string $registrationCode): ?object;
    public function getPartiesByRelaasId(int $relaasId): Collection;
    public function create(array $data): object;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
