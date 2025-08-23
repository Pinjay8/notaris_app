<?php

namespace App\Services;

use App\Models\NotaryRelaasParties;
use App\Repositories\Interfaces\RelaasPartiesRepositoryInterface;

class RelaasPartiesService
{
    protected $repo;

    public function __construct(RelaasPartiesRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function searchRelaas(string $registrationCode)
    {
        return $this->repo->searchByRegistrationCode($registrationCode);
    }

    public function getParties(int $relaasId)
    {
        return $this->repo->getPartiesByRelaasId($relaasId);
    }

    public function findById($id)
    {
        return NotaryRelaasParties::findOrFail($id);
    }

    public function store(array $data)
    {
        return $this->repo->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function destroy(int $id)
    {
        return $this->repo->delete($id);
    }
}
