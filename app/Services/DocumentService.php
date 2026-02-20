<?php

namespace App\Services;

use App\Models\Documents;
use App\Repositories\Interfaces\DocumentRepositoryInterface;

class DocumentService
{
    public function __construct(protected DocumentRepositoryInterface $documentRepo) {}

    public function getAll(?string $search = null, string $status = '1')
    {
        if ($search) {
            return $this->documentRepo->search($search, $status);
        }

        return $this->documentRepo->all($status);
    }

    public function searchDocuments(string $keyword, string $status = '1')
    {
        return $this->documentRepo->search($keyword, $status);
    }

    public function createDocument(array $data): Documents
    {
        return $this->documentRepo->create($data);
    }

    public function updateDocument(Documents $document, array $data): Documents
    {
        return $this->documentRepo->update($document, $data);
    }

    public function deactivate(int $id): bool
    {
        $document = $this->documentRepo->find($id);

        if (!$document) {
            throw new \Exception('Dokumen tidak ditemukan.');
        }

        return $this->documentRepo->deactivate($document);
    }

    public function activeDocument(int $id): bool
    {
        $document = $this->documentRepo->find($id);

        if (!$document) {
            throw new \Exception('Dokumen tidak ditemukan.');
        }

        return $this->documentRepo->activeDocument($document);
    }


    public function findProduct(int $id): ?Documents
    {
        return $this->documentRepo->find($id);
    }
}
