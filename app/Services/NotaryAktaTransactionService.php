<?php

namespace App\Services;

use App\Repositories\Interfaces\NotaryAktaTransactionRepositoryInterface;

class NotaryAktaTransactionService
{
    protected $repository;

    public function __construct(NotaryAktaTransactionRepositoryInterface $repository)
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

    public function updateStatus(int $id, string $status)
    {
        return $this->repository->updateStatus($id, $status);
    }
}
