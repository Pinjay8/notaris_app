<?php

namespace App\Services;

use App\Repositories\Interfaces\NotaryRelaasAktaRepositoryInterface;

class NotaryRelaasAktaService
{
    protected $repo;

    public function __construct(NotaryRelaasAktaRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function getAll($perPage = 10)
    {
        return $this->repo->paginate($perPage);
    }

    public function getById($id)
    {
        return $this->repo->find($id);
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repo->delete($id);
    }

    public function searchByRegistrationCode(string $code, $perPage = 10)
    {
        return $this->repo->searchByRegistrationCode($code, $perPage);
    }

    public function filterByStatus(string $status, $perPage = 10)
    {
        return $this->repo->filterByStatus($status, $perPage);
    }
}
