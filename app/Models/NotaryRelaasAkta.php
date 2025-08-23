<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaryRelaasAkta extends Model
{
    use LogsActivityCustom, SoftDeletes;

    protected $table = 'notary_relaas_aktas';
    protected $fillable = [
        'notaris_id',
        'client_id',
        'registration_code',
        'year',
        'relaas_number',
        'relaas_number_created_at',
        'title',
        'story',
        'story_date',
        'story_location',
        'status',
        'note'
    ];

    public function notaris()
    {
        return $this->belongsTo(Notaris::class, 'notaris_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function parties()
    {
        return $this->hasMany(NotaryRelaasParties::class, 'notary_relaas_akta_id');
    }

    protected $casts = [
        'relaas_number_created_at' => 'datetime',
    ];
}
