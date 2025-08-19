<?php

namespace App\Repositories;

use App\Models\NotaryClientDocument;
use App\Models\NotaryClientProduct;
use App\Models\Product;
use App\Models\ProductDocuments;
use App\Repositories\Interfaces\NotaryClientProductRepositoryInterface;

class NotaryClientProductRepository implements NotaryClientProductRepositoryInterface
{
    public function getAllWithLastProgress(array $filters = [])
    {
        $query = NotaryClientProduct::query();

        if (!empty($filters['registration_code'])) {
            $query->where('registration_code', 'like', '%' . $filters['registration_code'] . '%');
        }
        if (!empty($filters['notaris_id'])) {
            $query->where('notaris_id', $filters['notaris_id']);
        }
        if (!empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }
        if (!empty($filters['product_id'])) {
            $query->where('product_id', $filters['product_id']);
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $products = $query->get();

        foreach ($products as $product) {
            $product->last_progress = $product->getLastProgress();
        }

        return $products;
    }

    public function getAllWithRequiredDocuments(array $filters = [])
    {
        $query = NotaryClientProduct::with(['client', 'product']);

        // filter by registration_code
        if (!empty($filters['registration_code'])) {
            $query->where('registration_code', 'like', '%' . $filters['registration_code'] . '%');
        }

        // filter by client name
        if (!empty($filters['client_name'])) {
            $query->whereHas('client', function ($q) use ($filters) {
                $q->where('fullname', 'like', '%' . $filters['client_name'] . '%'); // pastikan field benar
            });
        }

        // default filter by status
        if (empty($filters['status'])) {
            $query->whereIn('status', ['new', 'progress']);
        } else {
            $query->where('status', $filters['status']);
        }

        $products = $query->get();

        foreach ($products as $product) {
            // ✅ Ambil dokumen wajib dari relasi product -> documents
            $requiredDocs = $product->product
                ? $product->product->documents->pluck('name')->toArray()
                : [];

            // ✅ Ambil dokumen yang sudah diupload klien
            $uploadedDocs = NotaryClientDocument::where('registration_code', $product->registration_code)
                ->pluck('document_name')
                ->toArray();

            // merge & format
            $allDocs = array_unique(array_merge($requiredDocs, $uploadedDocs));
            $product->documents_list = implode(', ', $allDocs);
        }

        return $products;
    }

    public function findByCompositeKey(array $keys)
    {
        return NotaryClientProduct::where('registration_code', $keys['registration_code'])
            ->where('notaris_id', $keys['notaris_id'])
            ->where('client_id', $keys['client_id'])
            ->where('product_id', $keys['product_id'])
            ->firstOrFail();
    }

    public function updateStatusByCompositeKey(array $keys, string $status)
    {
        $product = $this->findByCompositeKey($keys);
        $product->status = $status;
        $product->save();
        return $product;
    }
}
