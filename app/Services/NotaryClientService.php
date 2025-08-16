<?php

namespace App\Services;

use App\Repositories\Interfaces\NotaryClientProductRepositoryInterface;
use App\Repositories\Interfaces\NotaryClientProgressRepositoryInterface;

class NotaryClientService
{
    protected $productRepository;
    protected $progressRepo;

    public function __construct(
        NotaryClientProductRepositoryInterface $productRepository,
        NotaryClientProgressRepositoryInterface $progressRepo
    ) {
        $this->productRepository = $productRepository;
        $this->progressRepo = $progressRepo;
    }

    public function listProducts(array $filters = [])
    {
        return $this->productRepository->getAllWithLastProgress($filters);
    }

    public function getProductByCompositeKey(array $keys)
    {
        return $this->productRepository->findByCompositeKey($keys);
    }

    public function getProgressHistory(array $keys)
    {
        return $this->progressRepo->getByCompositeKey($keys);
    }

    public function addProgress(array $keys, array $data)
    {
        return $this->progressRepo->createProgress($keys, $data);
    }

    public function markCompleted(array $keys)
    {
        return $this->productRepository->updateStatusByCompositeKey($keys, 'done');
    }


}
