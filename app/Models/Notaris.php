<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notaris extends Model
{
    //

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
}
