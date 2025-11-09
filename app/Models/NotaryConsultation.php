<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaryConsultation extends Model
{

    use LogsActivityCustom,SoftDeletes;

    protected $table = 'notary_consultations';

    protected $fillable = [
        'notaris_id',
        'client_id',
        'registration_code',
        'subject',
        'description',
        'status'
    ];

    public function notaris()
    {
        return $this->belongsTo(Notaris::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        return $this->hasMany(NotaryClientProduct::class, 'registration_code', 'registration_code');
    }
}
