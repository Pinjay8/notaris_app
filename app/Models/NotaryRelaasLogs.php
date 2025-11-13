<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaryRelaasLogs extends Model
{
    protected $table = 'notary_relaas_logs';

    protected $fillable = [
        'notaris_id',
        'client_code',
        'registration_code',
        'relaas_id',
        'step',
        'note'
    ];
    public function notaris()
    {
        return $this->belongsTo(Notaris::class, 'notaris_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
