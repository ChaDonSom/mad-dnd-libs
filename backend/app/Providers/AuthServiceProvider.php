<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Permission::class => PermissionPolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
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
