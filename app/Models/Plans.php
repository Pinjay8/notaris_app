<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plans extends Model
{
    use LogsActivityCustom, SoftDeletes;
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
