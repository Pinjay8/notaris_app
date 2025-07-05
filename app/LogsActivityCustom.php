<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


trait LogsActivityCustom
{
    public static function bootLogsActivityCustom()
    {
        static::created(function ($model) {
            if (Auth::check()) {
                $model->logActivity('create');
            }
        });

        static::updated(function ($model) {
            if (Auth::check()) {
                $model->logActivity('update');
            }
        });

        static::deleted(function ($model) {
            if (Auth::check()) {
                $model->logActivity('delete');
            }
        });
    }

    public function logActivity($action)
    {
        \App\Models\ActivityLog::create([
            'user_id'    => Auth::id(),
            'menu'       => $this->getMenuName(),
            'action'     => $action,
            'data_type'  => class_basename($this),
            'data_id'    => $this->id,
            'ip_address' => request()->ip(),
            'description' => $this->buildDescription($action),
        ]);
    }

    protected function getMenuName()
    {
        return Str::slug(class_basename($this), '_'); // contoh: User → user
    }

    protected function buildDescription($action)
    {
        return "User melakukan $action pada {$this->getMenuName()} ID {$this->id}";
    }
}
