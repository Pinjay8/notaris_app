<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Documents;
use App\Models\Product;

class ProductDocuments extends Model
{
    //
    protected $table = 'product_documents';

    protected $fillable = [
        'product_code',
        'document_code',
        'description',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_code');
    }

    public function document()
    {
        return $this->belongsTo(Documents::class, 'document_code');
    }
}
