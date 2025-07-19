<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = ['name', 'code_products', 'description', 'image', 'status'];

    public function getImageProduct()
    {
        if (!$this->image || !Storage::exists($this->image)) {
            return asset('img/team-4.jpg'); // fallback ke gambar default di public/img
        }

        return Storage::url($this->image);
    }

    public function documents()
    {
        return $this->belongsToMany(Documents::class, 'product_documents', 'product_code', 'document_code')
            ->withPivot('description', 'status')
            ->withTimestamps();
    }
}
