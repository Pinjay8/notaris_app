<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plans extends Model
{
    //
    protected $table = 'plans';

    protected $fillable = [
        'id',
        'name',
        'description',
        'price',
        'duration_days',
        'status'
    ];
}
