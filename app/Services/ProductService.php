<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    public function __construct(protected ProductRepositoryInterface $productRepo) {}

    public function getAll(?string $search = null, string $status = '1')
    {
        if ($search) {
            return $this->productRepo->search($search, $status);
        }

        return $this->productRepo->all($status);
    }

    public function searchProducts(string $keyword, bool $includeInactive = false)
    {
        return $this->productRepo->search($keyword, $includeInactive);
    }

    public function createProduct(array $data): Product
    {
        return $this->productRepo->create($data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        return $this->productRepo->update($product, $data);
    }

    public function deactivate(int $id): bool
    {
        $product = $this->productRepo->find($id);

        if (!$product) {
            throw new \Exception('Produk tidak ditemukan.');
        }

        return $this->productRepo->deactivate($product);
    }

    public function findProduct(int $id): ?Product
    {
        return $this->productRepo->find($id);
    }
}
