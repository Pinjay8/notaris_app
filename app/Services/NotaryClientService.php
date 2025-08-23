<?php

namespace App\Services;

use App\Repositories\Interfaces\NotaryClientProductRepositoryInterface;
use App\Repositories\Interfaces\NotaryClientProgressRepositoryInterface;
use App\Repositories\Interfaces\NotaryClientDocumentRepositoryInterface;
use App\Repositories\Interfaces\NotaryClientWarkahRepositoryInterface;

class NotaryClientService
{
    protected $productRepository;
    protected $progressRepo;
    protected $documentRepository;
    protected $warkahRepository;

    public function __construct(
        NotaryClientProductRepositoryInterface $productRepository,
        NotaryClientProgressRepositoryInterface $progressRepo,
        NotaryClientDocumentRepositoryInterface $documentRepository,
        NotaryClientWarkahRepositoryInterface $warkahRepository
    ) {
        $this->productRepository = $productRepository;
        $this->progressRepo = $progressRepo;
        $this->documentRepository = $documentRepository;
        $this->warkahRepository = $warkahRepository;
    }

    // List Product Progress
    public function listProducts(array $filters = [])
    {
        return $this->productRepository->getAllWithLastProgress($filters);
    }

    public function getProductByCompositeKey(array $keys)
    {
        return $this->productRepository->findByCompositeKey($keys);
    }

    public function addProgress(array $keys, array $data)
    {
        return $this->progressRepo->createProgress($keys, $data);
    }

    public function getProgressHistory(array $keys)
    {
        return $this->progressRepo->getByCompositeKey($keys);
    }

    public function markCompleted(array $keys)
    {
        return $this->productRepository->updateStatusByCompositeKey($keys, 'done');
    }

    // Document

    public function listDocuments(array $filters = [])
    {
        return $this->productRepository->getAllWithRequiredDocuments($filters);
    }

    public function getDocumentHistory(array $keys)
    {
        return $this->documentRepository->getByCompositeKey($keys);
    }

    public function addDocument(array $keys, array $data)
    {
        return $this->documentRepository->createDocument($keys, $data);
    }

    public function updateStatusDocument(array $keys)
    {
        return $this->documentRepository->updateStatusByCompositeKey($keys, 'valid');
    }

    public function markCompleteds(array $keys)
    {
        return $this->productRepository->updateStatusByCompositeKey($keys, 'done');
    }

    // Warkah
    public function listWarkah(array $filters = [])
    {
        return $this->productRepository->getAllWithRequiredWarkah($filters);
    }

    public function addWarkah(array $keys, array $data)
    {
        return $this->warkahRepository->createWarkah($keys, $data);
    }

    public function getWarkahHistory(array $keys)
    {
        return $this->warkahRepository->getByCompositeKey($keys);
    }

    public function updateStatusWarkah(array $keys)
    {
        return $this->warkahRepository->updateStatusByCompositeKey($keys, 'valid');
    }

    public function markCompletedWarkah(array $keys)
    {
        return $this->productRepository->updateStatusByCompositeKey($keys, 'done');
    }
}
