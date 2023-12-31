<?php

namespace App\Providers;

use App\Models\User;
use Database\Factories\TicketFactory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', static function (?User $user) {
            return $user?->role === 'admin';
        });

        Blade::if('admin', static function () {
            return Gate::allows('admin');
        });

        Gate::define('agent', static function (?User $user) {
            return $user?->role === 'agent';
        });

        Blade::if('agent', static function () {
            return Gate::allows('agent');
        });

        Gate::define('client', static function (?User $user) {
            return $user?->role === 'client';
        });

        Blade::if('client', static function () {
            return Gate::allows('client');
        });

        Validator::extend('severity', static function ($attribute, $value) {
            return in_array($value, TicketFactory::$severities, true);
        }, 'Severity value unknown.');

        Validator::extend('status', static function ($attribute, $value) {
            return in_array($value, TicketFactory::$statuses, true);
        }, 'Status value unknown.');

        Validator::extend('agent', static function ($attribute, $value) {
            return User::find($value)?->role === 'agent';
        }, 'User not found or is not an agent.');
    }
}
