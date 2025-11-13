<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaryLegalisasi extends Model
{

    use LogsActivityCustom, SoftDeletes;
    protected $table = 'notary_legalisasis';

    protected $fillable = [
        'notaris_id',
        'client_code',
        'legalisasi_number',
        'applicant_name',
        'officer_name',
        'document_type',
        'document_number',
        'request_date',
        'release_date',
        'notes',
        'file_path'
    ];

    public function notaris()
    {
        return $this->belongsTo(Notaris::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_code', 'client_code');
    }
}
