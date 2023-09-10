<?php

namespace App\Providers;

use App\Events\NewComment;
use App\Events\NewTicket;
use App\Events\TicketStatus;
use App\Listeners\SendNewCommentNotification;
use App\Listeners\SendNewTicketNotification;
use App\Listeners\SendNewUserNotification;
use App\Listeners\SendTicketStatusNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendNewUserNotification::class,
        ],
        NewTicket::class => [
            SendNewTicketNotification::class,
        ],
        NewComment::class => [
            SendNewCommentNotification::class,
        ],
        TicketStatus::class => [
            SendTicketStatusNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
