<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class AuthServiceProvider extends ServiceProvider
{
    public static array $allowedDomains = [
        'laravel.com',
        'sqlite.org',
        'docker.com'
    ];

    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Validator::extend('allowed_domain', static function ($attribute, $value) {
            return in_array(explode('@', $value)[1], AuthServiceProvider::$allowedDomains, true);
        }, 'Domain not valid for registration.');

        Gate::define('view-ticket', function (User $user, Ticket $ticket) {
            if ($user->can('client')) {
                return $user->id === $ticket->user_id;
            }

            if ($user->can('agent')) {
                return $user->id === $ticket->agent_id;
            }

            if ($user->can('admin')) {
                return true;
            }

            return false;
        });

        Gate::define('create-ticket', function (User $user){
           return $user->can('client');
        });

        Gate::define('create-comment', function (User $user, int $ticketId){
            $ticket = Ticket::find($ticketId);

            return $ticket->user_id === Auth::id()
                || $ticket->agent_id === Auth::id()
                || $user->can('admin');
        });
    }
}
