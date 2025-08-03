<?php

namespace App\Models;

use App\LogsActivityCustom;
use App\Models\Documents;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDocuments extends Model
{
    use LogsActivityCustom, SoftDeletes;

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
