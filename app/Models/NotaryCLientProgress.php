<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaryCLientProgress extends Model
{
    protected $table = 'notary_client_progress';

    use SoftDeletes, LogsActivityCustom;

    protected $fillable = [
        'notaris_id',
        'client_id',
        'registration_code',
        'product_id',
        'progress',
        'progress_date',
        'note',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function notaris()
    {
        return $this->belongsTo(Notaris::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
