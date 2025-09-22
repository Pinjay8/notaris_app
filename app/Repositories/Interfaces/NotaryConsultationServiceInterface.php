<?php

namespace App\Repositories\Interfaces;

use App\Models\NotaryConsultation;
use Illuminate\Support\Collection;

interface NotaryConsultationServiceInterface
{
    public function all(): Collection;
    public function findById(int $id): ?NotaryConsultation;
    public function create(array $data): NotaryConsultation;
    public function update(int $id, array $data): ?NotaryConsultation;
    public function generateRegistrationCode(int $notarisId, int $clientId): string;
    public function getProductByConsultation(int $consultationId);
}
