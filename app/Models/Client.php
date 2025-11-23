<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Client extends Model
{
    use LogsActivityCustom, SoftDeletes;
    protected $table = 'clients';

    protected $fillable = [
        'client_code',
        'notaris_id',
        'uuid',
        'fullname',
        'nik',
        'birth_place',
        'gender',
        'marital_status',
        'job',
        'address',
        'city',
        'province',
        'postcode',
        'phone',
        'email',
        'npwp',
        'type',
        'company_name',
        'status',
        'note',
    ];

    public function notaris()
    {
        return $this->belongsTo(Notaris::class, 'notaris_id', 'id');
    }

    public function aktaTransactions()
    {
        return $this->hasMany(NotaryAktaTransaction::class, 'client_code', 'client_code');
    }

      public function aktaTransactionsRelaas()
    {
        return $this->hasMany(NotaryRelaasAkta::class, 'client_code', 'client_code');
    }


}
