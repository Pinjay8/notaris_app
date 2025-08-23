<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface NotaryRelaasDocumentServiceInterface
{
    public function search(string $keyword);
    public function getById(int $id);
    public function store(array $data);
    public function updateStatus(int $id, string $status);
    public function delete(int $id);
}
