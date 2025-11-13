<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaryRelaasDocument extends Model
{

    protected $table = 'notary_relaas_documents';

    protected $fillable = [
        'notaris_id',
        'client_code',
        'registration_code',
        'relaas_id',
        'name',
        'type',
        'file_name',
        'file_url',
        'file_type',
        'uploaded_at'
    ];

    public function notaris()
    {
        return $this->belongsTo(Notaris::class, 'notaris_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function relaases()
    {
        return $this->belongsTo(NotaryRelaasAkta::class, 'relaas_id');
    }

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];
}
