<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    //
    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'menu',
        'action',
        'data_type',
        'data_id',
        'ip_address',
        'description'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
