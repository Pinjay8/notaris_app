<?php

namespace App\Services;

use App\Repositories\Interfaces\NotaryAktaTypeRepositoryInterface;

class NotaryAktaTypeService
{
    protected $repository;

    public function __construct(NotaryAktaTypeRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function list(array $filters = [])
    {
        return $this->repository->all($filters);
    }

    public function get(int $id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->repository->delete($id);
    }
}