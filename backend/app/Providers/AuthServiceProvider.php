<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // Define gates for roles
        Gate::define('is-admin', fn($user) => $user->isAdmin());
        Gate::define('is-host', fn($user) => $user->hasRole('host'));
        Gate::define('is-player', fn($user) => $user->hasRole('player'));

        // Define gates for permissions
        Gate::define('host-game', fn($user) => $user->hasPermission('host_game'));
        Gate::define('manage-players', fn($user) => $user->hasPermission('manage_players'));
        Gate::define('configure-game', fn($user) => $user->hasPermission('configure_game'));
    }
}
