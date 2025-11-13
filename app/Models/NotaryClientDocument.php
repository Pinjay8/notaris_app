<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class NotaryClientDocument extends Model
{
    use SoftDeletes, LogsActivityCustom;

    protected $table = 'notary_client_documents';

    protected $fillable = [
        'notaris_id',
        'client_code',
        'registration_code',
        'document_code',
        'document_name',
        'note',
        'document_link',
        'uploaded_at',
        'status'
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

    // image

    public function image()
    {
        return Storage::url($this->document_link);
    }

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];
}
