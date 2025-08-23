<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaryRelaasParties extends Model
{
    protected $table = 'notary_relaas_parties';

    protected $fillable = [
        'notaris_id',
        'client_id',
        'registration_code',
        'relaas_id',
        'name',
        'role',
        'address',
        'id_number',
        'id_type'
    ];
    public function notaris()
    {
        return $this->belongsTo(Notaris::class, 'notaris_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function relaases()
    {
        return $this->belongsTo(NotaryRelaasAkta::class, 'relaas_id');
    }
}
