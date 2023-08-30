<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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
    }
}
