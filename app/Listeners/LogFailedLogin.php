<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogFailedLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        activity('auth')
            ->causedBy($event->user ?? null)
            ->withProperties([
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'email_attempted' => request('email'), // pour Failed
            ])
            ->log('Échec de connexion');
    }
}
