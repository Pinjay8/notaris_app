<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentRequest extends FormRequest
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
        $productId = $this->route('product')?->id;

        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            // 'notaris_id' => 'required',
            'status' => 'required',
        ];

        if ($this->isMethod('post')) {
            // Untuk create
            $rules['code'] = 'required|string|unique:documents,code';
            // $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5000';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $documentId = $this->route('document'); // ini sudah ID, bukan object
            $rules['code'] = 'required|string|unique:documents,code,' . $documentId;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'code.required' => 'Kode dokumen harus diisi.',
            'code.unique' => 'Kode dokumen harus unik',
            'description.required' => 'Deskripsi dokumen harus diisi.',
            'name.required' => 'Nama dokumen harus diisi.',
            // 'image.required' => 'Gambar dokumen harus diisi.',
            'status.required' => 'Status dokumen harus diisi.',
        ];
    }
}
