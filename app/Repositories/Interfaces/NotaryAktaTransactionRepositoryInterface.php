<?php

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;

interface NotaryAktaTransactionRepositoryInterface
{
    public function all(array $filters = []): Collection;
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function updateStatus(int $id, string $status);
}