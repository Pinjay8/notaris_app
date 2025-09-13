<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaryCost extends Model
{
    protected $table = 'notary_costs';

    protected $fillable = [
        'notaris_id',
        'client_id',
        'pic_document_id',
        'payment_code',
        'product_cost',
        'admin_cost',
        'other_cost',
        'total_cost',
        'amount_paid',
        'payment_status',
        'paid_date',
        'due_date',
        'note',
    ];

    public function notaris()
    {
        return $this->belongsTo(Notaris::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function picDocument()
    {
        return $this->belongsTo(PicDocuments::class);
    }

    public function payments()
    {
        return $this->hasMany(NotaryPayment::class, 'payment_code', 'payment_code');
    }
}
