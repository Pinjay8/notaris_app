<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:clients,nik',
            'birth_place' => 'required|string',
            'gender' => 'required|in:male,female',
            'marital_status' => 'required|string',
            'job' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'province' => 'required|string',
            'postcode' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'type' => 'required|in:personal,company',
            'status' => 'nullable|in:pending,valid,revisi',
            'note' => 'required|string',
            'company_name' => 'required|string',
            'npwp' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'fullname.required' => 'Nama lengkap harus diisi.',
            'nik.required' => 'NIK harus diisi.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'birth_place.required' => 'Tempat lahir harus diisi.',
            'gender.required' => 'Jenis kelamin harus diisi.',
            'marital_status.required' => 'Status perkawinan harus diisi.',
            'job.required' => 'Pekerjaan harus diisi.',
            'address.required' => 'Alamat harus diisi.',
            'city.required' => 'Kota harus diisi.',
            'province.required' => 'Provinsi harus diisi.',
            'postcode.required' => 'Kode pos harus diisi.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'email.required' => 'Email harus diisi.',
            'type.required' => 'Tipe harus diisi.',
            'company_name.required' => 'Nama perusahaan harus diisi.',
            'npwp.required' => 'NPWP harus diisi.',
        ];
    }
}
