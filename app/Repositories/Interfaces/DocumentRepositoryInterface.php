<?php

namespace App\Repositories\Interfaces;

use App\Models\Documents;

interface DocumentRepositoryInterface
{
    public function all(string $status = '1');
    public function search(string $keyword, string $status = '1');
    public function create(array $data): Documents;
    public function update(Documents $document, array $data): Documents;
    public function deactivate(Documents $document): bool;
    public function activeDocument(Documents $document): bool;
    public function find(int $id): ?Documents;
}
