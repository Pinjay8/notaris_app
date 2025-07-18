<?php

namespace App\Models;

use App\LogsActivityCustom;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use LogsActivityCustom;

    protected $table = 'subscriptions';

    protected $fillable = [
        'user_id',
        'plan_id',
        'start_date',
        'end_date',
        'payment_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plans::class);
    }
}
