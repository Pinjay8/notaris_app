<?php

namespace App\Repositories;

use App\Models\NotaryAktaDocument;
use App\Models\NotaryAktaDocuments;
use App\Repositories\Interfaces\NotaryAktaDocumentRepositoryInterface;

class NotaryAktaDocumentRepository implements NotaryAktaDocumentRepositoryInterface
{
    public function all(array $filters = [])
    {
        $query = NotaryAktaDocuments::query();

        if (!empty($filters['registration_code'])) {
            $query->where('registration_code', 'like', '%' . $filters['registration_code'] . '%');
        }

        if (!empty($filters['akta_number'])) {
            $query->where('akta_number', 'like', '%' . $filters['akta_number'] . '%');
        }

        return $query->get();
    }

    public function getById($id)
    {
        return NotaryAktaDocuments::findOrFail($id);
    }

    public function create(array $data)
    {
        return NotaryAktaDocuments::create($data);
    }

    public function update($id, array $data)
    {
        $document = $this->getById($id);
        $document->update($data);
        return $document;
    }

    public function delete($id)
    {
        $document = $this->getById($id);
        return $document->delete();
    }
}
