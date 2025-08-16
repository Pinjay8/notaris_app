<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\NotaryCLientProgress;

class NotaryClientProduct extends Model
{

    use SoftDeletes, LogsActivityCustom;
    protected $table = 'notary_client_products';

    protected $fillable = [
        'notaris_id',
        'client_id',
        'registration_code',
        'product_id',
        'note',
        'status',
        'completed_at'
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
    public function consultation()
    {
        return $this->belongsTo(NotaryConsultation::class, 'registration_code', 'registration_code');
    }

    public function progresses()
    {
        return $this->hasMany(NotaryCLientProgress::class, 'registration_code', 'registration_code');
    }

    public function getLastProgress()
    {
        return $this->progresses()->latest()->first();
    }
}
