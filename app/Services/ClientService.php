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
        $validated = $this->validate($data, $id = null);
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

    protected function validate(array $data, $id = null,)
    {
        $rules = [
            'fullname' => 'required|string|max:255',
            'nik' => 'required',
            'birth_place' => 'required|string|max:255',
            'gender' => 'required',
            'marital_status' => 'required|string',
            'job' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postcode' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'npwp' => 'required|string',
            'type' => 'required|in:personal,company',
            'company_name' => 'nullable|string',
            'status' => 'required',
            'note' => 'nullable|string',
        ];

        $messages = [
            'fullname.required' => 'Nama lengkap wajib diisi.',
            'fullname.max'      => 'Nama lengkap maksimal 255 karakter.',
            'nik.required'      => 'NIK wajib diisi.',
            'birth_place.required' => 'Tempat lahir wajib diisi.',
            'gender.required'   => 'Jenis kelamin wajib dipilih.',
            'marital_status.required' => 'Status pernikahan wajib dipilih.',
            'job.required'      => 'Pekerjaan wajib diisi.',
            'address.required'  => 'Alamat wajib diisi.',
            'city.required'     => 'Kota wajib diisi.',
            'province.required' => 'Provinsi wajib diisi.',
            'postcode.required' => 'Kode pos wajib diisi.',
            'phone.required'    => 'Nomor telepon wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'npwp.required'     => 'NPWP wajib diisi.',
            'type.required'     => 'Tipe klien wajib dipilih.',
            'type.in'           => 'Tipe klien hanya boleh "personal" atau "company".',
            'status.required'   => 'Status wajib diisi.',
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
