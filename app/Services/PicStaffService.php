<?php

namespace App\Services;
use App\Repositories\Interfaces\PicStaffRepositoryInterface;
use App\Models\PicStaff;

class PicStaffService
{
    protected $repository;

    public function __construct(PicStaffRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(?string $search = null)
    {
        return $this->repository->all($search);
    }

    public function store(array $data): PicStaff
    {
        return $this->repository->create($data);
    }

    public function update(PicStaff $picStaff, array $data): bool
    {
        return $this->repository->update($picStaff, $data);
    }

    public function destroy(PicStaff $picStaff): bool
    {
        return $this->repository->delete($picStaff);
    }
}
