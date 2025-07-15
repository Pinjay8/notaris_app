<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function all(string $status = '1');
    public function search(string $keyword, string $status = '1');
    public function create(array $data): Product;
    public function update(Product $product, array $data): Product;
    public function deactivate(Product $product): bool;
    public function find(int $id): ?Product;
}
