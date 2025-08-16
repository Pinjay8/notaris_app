<?php

namespace App\Repositories;

use App\Models\NotaryClientProduct;
use App\Models\NotaryConsultation;
use App\Repositories\Interfaces\NotaryConsultationServiceInterface;
use Illuminate\Support\Collection;

class NotaryConsultationRepository implements NotaryConsultationServiceInterface
{
    public function all(): Collection
    {
        return NotaryConsultation::all();
    }

    public function findById(int $id): ?NotaryConsultation
    {
        return NotaryConsultation::find($id);
    }

    public function create(array $data): NotaryConsultation
    {
        return NotaryConsultation::create($data);
    }


    public function update(int $id, array $data): ?NotaryConsultation
    {
        $notary = NotaryConsultation::findOrFail($id);
        $notary->update($data);
        return $notary;  // kembalikan model setelah update
    }

    public function generateRegistrationCode(int $notarisId): string
    {
        return NotaryConsultation::generateRegistrationCode($notarisId);
    }

    public function getProductByConsultation(int $consultationId)
    {
        return NotaryClientProduct::where('consultation_id', $consultationId)->first();
    }
}
