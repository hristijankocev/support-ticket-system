<?php

namespace App\Notifications;

enum NotificationType
{
    case NewUser;
    case NewComment;
    case NewTicket;
    case TicketStatusUpdated;
    case TicketAssigned;
}
