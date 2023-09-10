<?php

namespace App\Events;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class TicketAssigned
{
    use SerializesModels;

    public Ticket $ticket;
    public User $user;

    public function __construct(Ticket $ticket, User $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
    }
}
