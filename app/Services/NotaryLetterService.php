<?php

namespace App\Services;

use App\Models\NotaryLetter;
use App\Models\NotaryLetters;
use App\Repositories\Interfaces\NotaryLetterRepositoryInterface;

class NotaryLetterService
{
    protected $repository;

    public function __construct(NotaryLetterRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(?string $search = null)
    {
        return $this->repository->all($search);
    }

    public function getById($id)
    {
        return $this->repository->find($id);
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
