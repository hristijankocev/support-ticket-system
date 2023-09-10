<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewCommentNotification;
use App\Notifications\NewTicketNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Builder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewCommentNotification
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
        $comment = $event->comment;

        $ticket = $comment->ticket;

        $usersToNotify = User::where('role', 'admin') // Admin users
        ->where('id', '!=', $comment->user_id)
            ->orWhere('id', $ticket->agent_id) // The agent assigned to the ticket
            ->where('id', '!=', $comment->user_id)
            ->orWhere(function ($query) use ($ticket, $comment) {
                // Author of the ticket
                $query->where('id', $ticket->user_id)
                    ->where('id', '!=', $comment->user_id);
            })->get();

        Notification::send($usersToNotify, new NewCommentNotification($event->comment));
    }
}
