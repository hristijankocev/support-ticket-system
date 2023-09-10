<?php

namespace App\Events;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Queue\SerializesModels;

class TicketStatus
{
    use SerializesModels;

    public Ticket $ticket;
    public User $user;
    public string $oldStatus;

    public function __construct(Ticket $ticket, User $user, string $oldStatus)
    {
        $this->ticket = $ticket;
        $this->user = $user;
        $this->oldStatus = $oldStatus;
    }
}
