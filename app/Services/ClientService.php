<?php

namespace App\Services;

use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ClientService
{
    protected $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function getAll()
    {
        return $this->clientRepository->all();
    }

    public function search(array $filters)
    {
        $filters['notaris_id'] = auth()->user()->notaris_id;
        return $this->clientRepository->search($filters);
    }
    public function getById($id)
    {
        return $this->clientRepository->findById($id);
    }

    public function create(array $data)
    {
        $validated = $this->validate($data);
        $validated['notaris_id'] = auth()->user()->notaris_id;
        return $this->clientRepository->create($validated);
    }

    public function update($id, array $data)
    {
        $validated = $this->validate($id, $data);
        $validated['notaris_id'] = auth()->user()->notaris_id ?? null;
        return $this->clientRepository->update($id, $validated);
    }

    public function delete($id)
    {
        return $this->clientRepository->delete($id);
    }

    protected function validate(array $data, $id = null)
    {
        $rules = [
            'fullname' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:clients,nik,' . ($id ?? 'null') . ',id',
            'birth_place' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'marital_status' => 'required|string',
            'job' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postcode' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'npwp' => 'nullable|string',
            'type' => 'required|in:personal,company',
            'company_name' => 'nullable|string',
            'status' => 'required|in:pending,valid,revisi',
            'note' => 'nullable|string',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated(); // ✅ Tambahkan ini
    }
}
