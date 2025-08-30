<?php

namespace App\Services;

use App\Repositories\Interfaces\NotaryLegalisasiRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class NotaryLegalisasiService
{
    protected $repository;

    public function __construct(NotaryLegalisasiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Ambil semua data dengan sorting & pencarian
     */
    public function list(array $filters, int $perPage = 10)
    {
        return $this->repository->getAll($filters, $perPage);
    }

    /**
     * Ambil satu data by ID
     */
    public function findById($id)
    {
        return $this->repository->findById($id);
    }

    /**
     * Buat data baru
     */
    public function create(array $data)
    {
        // $this->validateData($data);
        return $this->repository->create($data);
    }

    /**
     * Update data by ID
     */
    public function update($id, array $data)
    {
        // $this->validateData($data, $id);
        return $this->repository->update($id, $data);
    }

    /**
     * Hapus data by ID (soft delete)
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    /**
     * Validasi data input
     */
    protected function validateData(array $data, $id = null)
    {
        $rules = [
            'notaris_id'         => 'required|exists:notaris,id',
            'client_id'          => 'required|exists:clients,id',
            'legalisasi_number'  => 'nullable|string|max:255',
            'applicant_name'     => 'nullable|string|max:255',
            'officer_name'       => 'nullable|string|max:255',
            'document_type'      => 'nullable|string|max:255',
            'document_number'    => 'nullable|string|max:255',
            'request_date'       => 'nullable|date',
            'release_date'       => 'nullable|date',
            'notes'              => 'nullable|string',
            'file_path'          => 'nullable|string',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
