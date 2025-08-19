<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaryAktaTransaction extends Model
{

    use SoftDeletes, LogsActivityCustom;
    protected $table = 'notary_akta_transactions';

    protected $fillable = [
        'notaris_id',
        'client_id',
        'akta_type_id',
        'registration_code',
        'year',
        'status',
        'akta_number',
        'akta_number_created_at',
        'date_submission',
        'date_finished',
        'note',
        'created_at',
        'updated_at'
    ];

    public function notaris()
    {
        return $this->belongsTo(Notaris::class);
    }

    public function akta_type()
    {
        return $this->belongsTo(NotaryAktaTypes::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    protected $casts = [
        'akta_number_created_at' => 'datetime',
    ];
}
