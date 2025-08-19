<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaryAktaTypes extends Model
{

    use LogsActivityCustom, SoftDeletes;
    protected $table = 'notary_akta_types';

    protected $fillable = [
        'notaris_id',
        'category',
        'type',
        'description',
        'documents',
    ];

    public function notaris()
    {
        return $this->belongsTo(Notaris::class);
    }
}
