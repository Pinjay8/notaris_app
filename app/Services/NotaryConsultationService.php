<?php

namespace App\Services;

use App\Models\NotaryConsultation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Repositories\Interfaces\NotaryConsultationServiceInterface;
use Carbon\Carbon;

class NotaryConsultationService
{
    protected $notaryRepository;
    public function __construct(NotaryConsultationServiceInterface $notaryRepository)
    {
        $this->notaryRepository = $notaryRepository;
    }

    public function getAll()
    {
        return $this->notaryRepository->all();
    }


    public function findById(int $id): ?NotaryConsultation
    {
        return $this->notaryRepository->findById($id);
    }


    public function create(array $data): NotaryConsultation
    {
        $validated = $this->validate($data);
        // if (!isset($data['registration_code']) && isset($data['notaris_id'])) {
        //     $data['registration_code'] = $this->generateRegistrationCode($data['notaris_id'], $data['client_id']);
        // }
        return $this->notaryRepository->create($data);
    }


    public function update(int $id, array $data)
    {
        $validated = $this->validate($data, $id); // parameter sesuai urutan

        // Jangan ubah registration_code pada update, kecuali memang ingin
        unset($validated['registration_code']);

        return $this->notaryRepository->update($id, $validated);
    }

    public function generateRegistrationCode(int $notarisId, int $clientId): string
    {
        $today = Carbon::now()->format('Ymd');

        // Hitung jumlah konsultasi notaris ini hari ini
        $countToday = NotaryConsultation::where('notaris_id', $notarisId)
            ->where('client_code', $clientId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $countToday += 1; // untuk konsultasi baru ini

        return 'N' . '-' . $today . '-' . $notarisId . '-' . $clientId . '-' . $countToday;
    }

    public function validate(array $data, $id = null)
    {
        $rules = [
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|in:progress,done',
            // 'registration_code' => 'nullable|string|max:50',
            'client_code' => 'required',
            'notaris_id' => 'required',
        ];

        $messages = [
            'subject.required' => 'Subjek konsultasi harus diisi.',
            'status.in' => 'Status tidak valid.',
            'client_code.required' => 'Klien harus dipilih.',
            'notaris_id.required' => 'Notaris tidak valid.',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }


    public function getProductByConsultation(int $consultationId)
    {
        return $this->notaryRepository->getProductByConsultation($consultationId);
    }
}
