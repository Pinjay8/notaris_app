<?php

namespace App\Services;

use App\Repositories\Interfaces\WaarmerkingRepositoryInterface;

class WaarmerkingService
{
    protected $repo;

    public function __construct(WaarmerkingRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function list(array $filters = [], int $perPage)
    {
        return $this->repo->getAll($filters, $perPage);
    }

    public function get(int $id)
    {
        return $this->repo->findById($id);
    }

    public function store(array $data)
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repo->delete($id);
    }
}