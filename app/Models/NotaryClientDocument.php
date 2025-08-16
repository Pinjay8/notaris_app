<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\LogsActivityCustom;

class NotaryClientDocument extends Model
{
    use SoftDeletes, LogsActivityCustom;

    protected $table = 'notary_client_products';

    protected $fillable = [
        'notaris_id',
        'client_id',
        'registration_code',
        'product_id',
        'document_code',
        'document_name',
        'note',
        'document_link',
        'uploaded_at',
        'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function notaris()
    {
        return $this->belongsTo(Notaris::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
