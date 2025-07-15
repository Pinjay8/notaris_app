<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'status' => 'required',
        ];

        if ($this->isMethod('post')) {
            // Untuk create
            $rules['code_products'] = 'required|string|unique:products,code_products';
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:5000';
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            // Untuk update
            $rules['code_products'] = 'required|string|unique:products,code_products,' . $productId;
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000';
        }

        return $rules;
    }

    // messaage indo
    public function messages()
    {
        return [
            'code_products.required' => 'Kode layanan harus diisi.',
            'description.required' => 'Deskripsi layanan harus diisi.',
            'name.required' => 'Nama layanan harus diisi.',
            'image.required' => 'Gambar layanan harus diisi.',
            'status.required' => 'Status layanan harus diisi.',
        ];
    }
}
