<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
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
        // The below were self-added
        $this->registerPolicies();

        //  Define a gate for logging out
        Gate::define('perform-logout', function ($user) {
            return $user instanceof \App\Models\Audience; // Ensure the user is an Audience instance
        });
    }
}
