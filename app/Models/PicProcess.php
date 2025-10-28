<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PicProcess extends Model
{

    protected $table = 'pic_processes';

    protected $fillable = [
        'notaris_id',
        'pic_document_id',
        'step_name',
        'step_status',
        'step_date',
        'note',
    ];

    public function pic_document()
    {
        return $this->belongsTo(PicDocuments::class, 'pic_document_id');
    }

    public function notaris()
    {
        return $this->belongsTo(Notaris::class);
    }

    protected $casts = [
        'step_date' => 'date',
    ];
}
