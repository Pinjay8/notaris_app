<?php

namespace App\Models;

use App\LogsActivityCustom;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;

class Documents extends Model
{

    protected $table = 'documents';
    use LogsActivityCustom, SoftDeletes;

    protected $fillable = ['name', 'code', 'description', 'status', 'notaris_id'];
    public function getImageDocument()
    {
        if (!$this->image || !Storage::exists($this->image)) {
            return asset('img/team-4.jpg'); // fallback ke gambar default di public/img
        }

        return Storage::url($this->image);
    }

    public function notaris()
    {
        return $this->belongsTo(Notaris::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_documents')
            ->withPivot('description', 'status')
            ->withTimestamps();
    }
}
