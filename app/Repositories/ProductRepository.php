<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Product;


class ProductRepository implements ProductRepositoryInterface
{
    public function all(string $status = '1')
    {
        $query = Product::query();

        if ($status === '1') {
            $query->where('status', 1); // hanya aktif
        } elseif ($status === '0') {
            $query->where('status', 0); // hanya nonaktif
        }
        // jika 'all', tampilkan semua

        return $query->get();
    }

    public function search(string $keyword, string $status = '1')
    {
        $query = Product::where(function ($q) use ($keyword) {
            $q->where('code_products', 'like', "%{$keyword}%")
                ->orWhere('name', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
        });

        if ($status === '1') {
            $query->where('status', 1);
        } elseif ($status === '0') {
            $query->where('status', 0);
        }

        return $query->get();
    }

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function deactivate(Product $product): bool
    {
        $product->status = false;
        return $product->save();
    }

    public function find(int $id): ?Product
    {
        return Product::find($id);
    }
}
