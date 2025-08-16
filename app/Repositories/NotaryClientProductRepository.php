<?php

namespace App\Repositories;

use App\Models\NotaryClientProduct;
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
