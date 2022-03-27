<?php

namespace App\Listeners;

use App\Events\SendMail;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;

class SendMailFired
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendMail  $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        Mail::to($event->email)->send(new VerifyEmail([
            'token' => $event->token,
            'email' => $event->email,
        ]));
    }
}
