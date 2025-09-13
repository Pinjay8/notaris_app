<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PicDocuments extends Model
{

    use LogsActivityCustom, SoftDeletes;
    protected $table = 'pic_documents';

    protected $fillable = [
        'notaris_id',
        'pic_id',
        'pic_document_code',
        'client_id',
        'registration_code',
        'document_type',
        'document_number',
        'received_date',
        'status',
        'note',
    ];

    public function pic()
    {
        return $this->belongsTo(PicStaff::class, 'pic_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function notaris()
    {
        return $this->belongsTo(Notaris::class, 'notaris_id');
    }
}
