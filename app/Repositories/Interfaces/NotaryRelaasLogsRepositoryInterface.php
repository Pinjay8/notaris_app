<?php

namespace App\Repositories\Interfaces;

use App\Models\NotaryRelaasLogs;

interface NotaryRelaasLogsRepositoryInterface
{
    public function getAll();
    public function findById(int $id): ?NotaryRelaasLogs;
    public function create(array $data): NotaryRelaasLogs;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
