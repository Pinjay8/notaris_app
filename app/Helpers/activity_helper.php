<?php

use App\Models\ActivityLog;

if (!function_exists('log_activity')) {
    function log_activity($menu, $action, $data_type, $data_id, $description = '')
    {
        if (auth()->check()) {
            ActivityLog::create([
                'user_id'    => auth()->id(),
                'menu'       => $menu,
                'action'     => $action,
                'data_type'  => $data_type,
                'data_id'    => $data_id,
                'ip_address' => request()->ip(),
                'description' => $description,
            ]);
        }
    }
}
