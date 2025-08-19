<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaryAktaLogs extends Model
{

    protected $table = 'notary_akta_logs';

    protected $fillable = [
        'notaris_id',
        'client_id',
        'registration_code',
        'akta_transaction_id',
        'registration_code',
        'step',
        'note'
    ];

    public function notaris()
    {
        return $this->belongsTo(Notaris::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function akta_transaction()
    {
        return $this->belongsTo(NotaryAktaTransaction::class);
    }
}
