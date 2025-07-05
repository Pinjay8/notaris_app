<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogAuthenticationActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    public function handle($event): void
    {
        $user = $event->user;

        log_activity(
            'auth',
            $event instanceof Login ? 'login' : 'logout',
            'users',
            $user->id,
            ucfirst($event instanceof Login ? 'User login' : 'User logout')
        );
    }
}
