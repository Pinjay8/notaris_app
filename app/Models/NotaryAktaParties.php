<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaryAktaParties extends Model
{

    use SoftDeletes, LogsActivityCustom;
    protected $table = 'notary_akta_parties';

    protected $fillable = [
        'notaris_id',
        'client_code',
        'akta_transaction_id',
        'registration_code',
        'name',
        'role',
        'address',
        'id_number',
        'id_type',
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

    public function akta_transaction()
    {
        return $this->belongsTo(NotaryAktaTransaction::class);
    }
}
