<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewTicketNotification;
use Illuminate\Support\Facades\Notification;

class SendNewTicketNotification
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
        $admins = User::all()->where('role', '=', 'admin');

        Notification::send($admins, new NewTicketNotification($event->user, $event->ticket));
    }
}
