<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\TicketAssignedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendTicketAssignedNotification
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
        $user = $event->user;
        $ticket = $event->ticket;

        $agent = User::all()->where('id', '=', $ticket->agent_id);

        Notification::send($agent, new TicketAssignedNotification($ticket, $user));
    }
}
