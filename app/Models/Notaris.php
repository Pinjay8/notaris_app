<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;

class Notaris extends Model
{
    //
    use LogsActivityCustom;

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
