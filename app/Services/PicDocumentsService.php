<?php

namespace App\Services;

use App\Repositories\Interfaces\PicDocumentsRepositoryInterface;
use Carbon\Carbon;

class PicDocumentsService
{
    protected $repository;

    public function __construct(PicDocumentsRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllDocuments($filters = [])
    {
        return $this->repository->getAll($filters);
    }

    public function getDocumentById($id)
    {
        return $this->repository->findById($id);
    }

    public function createDocument(array $data)
    {
        // generate code: datenow-notarisID-picID-clientID
        $data['pic_document_code'] = Carbon::now()->format('Ymd')
            . '-' . $data['notaris_id']
            . '-' . $data['client_id']
            . '-' . $data['pic_id'];

        return $this->repository->create($data);
    }

    public function updateDocument($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteDocument($id)
    {
        return $this->repository->delete($id);
    }
}
