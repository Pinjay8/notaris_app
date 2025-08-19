<?php

namespace App\Repositories;

use App\Models\NotaryClientDocument;
use App\Repositories\Interfaces\NotaryClientDocumentRepositoryInterface;
use Illuminate\Support\Facades\Log;

class NotaryClientDocumentRepository implements NotaryClientDocumentRepositoryInterface
{

    public function getByCompositeKey(array $keys)
    {
        return NotaryClientDocument::where('registration_code', $keys['registration_code'])
            ->where('notaris_id', $keys['notaris_id'])
            ->where('client_id', $keys['client_id'])
            ->where('product_id', $keys['product_id'])
            ->get();
    }

    public function createDocument(array $keys, array $data)
    {
        $dataToCreate = array_merge($keys, [
            'document_code'  => $data['document_code'], // ambil dari product_document
            'document_name'  => $data['document_name'],
            'note'           => $data['note'],
            'document_link'  => $data['document_link'],
            'uploaded_at'    => $data['uploaded_at'],
            'status'         => $data['status'],
        ]);

        return NotaryClientDocument::create($dataToCreate);
    }
}
