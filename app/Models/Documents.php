<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Documents extends Model
{
    //
    protected $fillable = ['name', 'code', 'description', 'image', 'link', 'status'];

    public function getImageDocument()
    {
        if (!$this->image || !Storage::exists($this->image)) {
            return asset('img/team-4.jpg'); // fallback ke gambar default di public/img
        }

        return Storage::url($this->image);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_documents')
            ->withPivot('description', 'status')
            ->withTimestamps();
    }
}
