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
}
