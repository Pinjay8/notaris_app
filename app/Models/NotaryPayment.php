<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaryPayment extends Model
{

    protected $table = 'notary_paymentts';
    protected $fillable = [
        'notaris_id',
        'client_id',
        'pic_document_id',
        'payment_code',
        'payment_type',
        'amount',
        'payment_date',
        'payment_method',
        'payment_file',
        'note',
        'is_valid'
    ];

    public function notaris()
    {
        return $this->belongsTo(Notaris::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function pic_document()
    {
        return $this->belongsTo(PicDocuments::class);
    }

    public function cost()
    {
        return $this->belongsTo(NotaryCost::class, 'payment_code', 'payment_code');
    }
}
