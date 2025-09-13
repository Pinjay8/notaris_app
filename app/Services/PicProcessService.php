<?php

namespace App\Services;

use App\Repositories\Interfaces\PicProcessRepositoryInterface;

class PicProcessService
{
    protected $repository;

    public function __construct(PicProcessRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getByPicDocumentCode($code)
    {
        return $this->repository->all(['pic_document_code' => $code]);
    }

    public function listProcesses(array $filters = [])
    {
        return $this->repository->all($filters);
    }

    public function getProcessById($id)
    {
        return $this->repository->find($id);
    }

    public function createProcess(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateProcess($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteProcess($id)
    {
        return $this->repository->delete($id);
    }
}
