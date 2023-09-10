<?php

namespace App\Events;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class NewTicket
{
    use SerializesModels;

    // The newly created ticket
    public Ticket $ticket;
    public User $user;

    public function __construct(User $user, Ticket $ticket)
    {
        $this->user = $user;
        $this->ticket = $ticket;
    }
}
