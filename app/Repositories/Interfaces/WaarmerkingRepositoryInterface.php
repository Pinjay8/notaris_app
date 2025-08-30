<?php

namespace App\Repositories\Interfaces;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface WaarmerkingRepositoryInterface
{
    public function getAll(array $filters,  int $perPage): LengthAwarePaginator;
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}
