<?php

namespace App\Models;

use App\Models\PicDocuments;
use Illuminate\Database\Eloquent\Model;

class PicHandOver extends Model
{
    protected $table = 'pic_hand_overs';
    protected $fillable = [
        'notaris_id',
        'pic_document_id',
        'handover_date',
        'recipient_name',
        'recipient_contact',
        'note',
        'file_path',
    ];

    public function notaris()
    {
        return $this->belongsTo(Notaris::class);
    }

    public function picDocument()
    {
        return $this->belongsTo(PicDocuments::class);
    }
}
