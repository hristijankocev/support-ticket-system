<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\TicketStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendTicketStatusNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $user = $event->user;
        $ticket = $event->ticket;
        $oldStatus = $event->oldStatus;

        $usersToNotify = User::where('role', 'admin') // Admin users
        ->where('id', '!=', $user->id)
            ->orWhere('id', $ticket->agent_id) // The agent assigned to the ticket
            ->where('id', '!=', $user->id)
            ->orWhere(function ($query) use ($ticket, $user) {
                // Author of the ticket
                $query->where('id', $ticket->user_id)
                    ->where('id', '!=', $user->id);
            })->get();

        Notification::send($usersToNotify, new TicketStatusNotification($ticket, $user, $oldStatus));
    }
}
