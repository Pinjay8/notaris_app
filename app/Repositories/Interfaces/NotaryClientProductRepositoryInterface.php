<?php

namespace App\Repositories\Interfaces;

interface NotaryClientProductRepositoryInterface
{
    public function getAllWithLastProgress(array $filters = []);
    public function getAllWithRequiredDocuments(array $filters = []);
    public function findByCompositeKey(array $keys);
    public function updateStatusByCompositeKey(array $keys, string $status);
}

interface NotaryClientProgressRepositoryInterface
{
    public function getByCompositeKey(array $keys);
    public function createProgress(array $keys, array $data);
}

interface NotaryClientDocumentRepositoryInterface
{
    public function getByCompositeKey(array $keys);
    public function createDocument(array $keys, array $data);
}

interface NotaryCLientWarkahRepositoryInterface
{
    public function getByCompositeKey(array $keys);
    public function createWarkah(array $keys, array $data);
}
