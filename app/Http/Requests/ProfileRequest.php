<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            // 'user_id' => ['required'],
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'display_name' => ['required', 'max:50'],
            'office_name' => ['required', 'max:50'],
            'office_address' => ['required', 'max:100'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:10000'],
            'background' => ['nullable'],
            'address' => ['required', 'max:100'],
            'phone' => ['required', 'string', 'min:10', 'max:15', 'regex:/^(\+?\d{1,3}[- ]?)?\d{10,14}$/'],
            'email' => ['required', 'email', 'max:255'],
            'gender' => ['required', 'string', 'max:100'],
            'information' => ['nullable'],
            'sk_ppat' => ['nullable'],
            'sk_ppat_date' => ['nullable', 'date'],
            'sk_notaris' => ['nullable'],
            'sk_notaris_date' => ['nullable', 'date'],
            'no_kta_ini' => ['nullable'],
            'no_kta_ippat' => ['nullable'],
        ];
    }

    // message in indonesia
    public function messages(): array
    {
        return [
            'first_name.required' => 'Nama depan harus diisi',
            'first_name.max' => 'Nama depan tidak boleh lebih dari 50 karakter',
            'last_name.required' => 'Nama belakang harus diisi',
            'last_name.max' => 'Nama belakang tidak boleh lebih dari 50 karakter',
            'display_name.required' => 'Nama panggilan harus diisi',
            'display_name.max' => 'Nama panggilan tidak boleh lebih dari 50 karakter',
            'office_name.required' => 'Nama perusahaan harus diisi',
            'office_name.max' => 'Nama perusahaan tidak boleh lebih dari 50 karakter',
            'office_address.required' => 'Alamat perusahaan harus diisi',
            'office_address.max' => 'Alamat perusahaan tidak boleh lebih dari 100 karakter',
            'image.image' => 'File gambar harus berupa gambar',
            'image.mimes' => 'File gambar harus berupa format jpeg, png, jpg, gif, atau svg',
            'image.max' => 'Ukuran file gambar tidak boleh lebih dari 5 MB',
            'background.required' => 'Background harus diisi',
            'address.required' => 'Alamat harus diisi',
            'address.max' => 'Alamat tidak boleh lebih dari 100 karakter',
            'phone.required' => 'Nomor telepon harus diisi',
            'phone.string' => 'Nomor telepon harus berupa string',
            'phone.min' => 'Nomor telepon harus memiliki panjang minimal 10 karakter',
            'phone.max' => 'Nomor telepon tidak boleh lebih dari 15 karakter',
            'phone.regex' => 'Format nomor telepon tidak valid',
            'email.required' => 'Alamat email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Alamat email tidak boleh lebih dari 255 karakter',
            'gender.required' => 'Jenis kelamin harus diisi',
            'information.required' => 'Informasi harus diisi'
        ];
    }
}
