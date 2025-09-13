<?php

namespace App\Services;

use App\Repositories\Interfaces\PicHandoverRepositoryInterface;

class PicHandoverService
{
    protected $repository;

    public function __construct(PicHandoverRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function listHandovers(array $filters = [])
    {
        return $this->repository->all($filters);
    }

    public function createHandover(array $data)
    {
        return $this->repository->create($data);
    }

    public function deleteHandover($id)
    {
        return $this->repository->delete($id);
    }
}
