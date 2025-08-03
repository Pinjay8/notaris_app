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
        'notaris_id',
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
}
