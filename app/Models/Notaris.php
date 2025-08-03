<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notaris extends Model
{
    //
    use LogsActivityCustom, SoftDeletes;

    protected $table = 'notaris';

    protected $fillable = [
        'first_name',
        'last_name',
        'display_name',
        'office_name',
        'office_address',
        'image',
        'background',
        'address',
        'phone',
        'email',
        'gender',
        'information',
    ];

    public function clients()
    {
        return $this->hasMany(Client::class, 'notaris_id', 'id');
    }
}
