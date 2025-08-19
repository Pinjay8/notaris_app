<?php

namespace App\Services;

use App\Repositories\Interfaces\NotaryAktaDocumentRepositoryInterface;

class NotaryAktaDocumentService
{
    protected $repository;

    public function __construct(NotaryAktaDocumentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function list(array $filters = [])
    {
        return $this->repository->all($filters);
    }

    public function get($id)
    {
        return $this->repository->getById($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
