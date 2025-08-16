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
        if (!isset($data['registration_code']) && isset($data['notaris_id'])) {
            $data['registration_code'] = $this->generateRegistrationCode($data['notaris_id']);
        }
        return $this->notaryRepository->create($data);
    }


    public function update(int $id, array $data)
    {
        $validated = $this->validate($data, $id); // parameter sesuai urutan

        // Jangan ubah registration_code pada update, kecuali memang ingin
        unset($validated['registration_code']);

        return $this->notaryRepository->update($id, $validated);
    }

    public function generateRegistrationCode(int $notarisId): string
    {
        $today = Carbon::now()->format('Ymd');

        // Hitung jumlah konsultasi notaris ini hari ini
        $countToday = NotaryConsultation::where('notaris_id', $notarisId)
            ->whereDate('created_at', Carbon::today())
            ->count();

        $countToday += 1; // untuk konsultasi baru ini

        return 'N' . $notarisId . '-' . $today . '-' . $countToday;
    }

    public function validate(array $data, $id = null)
    {
        $rules = [
            'notaris_id' =>  'required|exists:notaris,id',
            'client_id' => 'required|exists:clients,id',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable',
            'registration_code' => 'nullable|string|max:50'
        ];

        $messages = [
            'notaris_id.required' => 'Notaris harus dipilih.',
            'notaris_id.exists' => 'Notaris tidak ditemukan.',
            'client_id.required' => 'Klien harus dipilih.',
            'client_id.exists' => 'Klien tidak ditemukan.',
            'subject.required' => 'Subjek konsultasi wajib diisi.',
            'status.in' => 'Status tidak valid.'
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
