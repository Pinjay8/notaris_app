<?php

namespace App\Services;

use App\Models\Client;
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
        // ambil tipe transaksi
        $type = $data['transaction_type'] ?? 'akta';

        // tentukan prefix
        $prefix = $type === 'ppat' ? 'PP' : 'PA';

        $client = Client::where('client_code', $data['client_code'])->first();
        if (!$client) {
            throw new \Exception('Client tidak ditemukan.');
        }


        // generate kode: prefix + tanggal + notarisID + clientID + picID
        $data['pic_document_code'] = $prefix
            . Carbon::now()->format('ymd') // contoh: 251112
            . '-' . $data['notaris_id']
            . '-' . $client->id   // karena kamu pakai client_code, bukan client_id
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
