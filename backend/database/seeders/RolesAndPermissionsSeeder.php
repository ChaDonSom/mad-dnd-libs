<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            ['name' => 'View Public Content', 'slug' => 'view_public_content'],
            ['name' => 'Join Game', 'slug' => 'join_game'],
            ['name' => 'View Game Content', 'slug' => 'view_game_content'],
            ['name' => 'Play Game', 'slug' => 'play_game'],
            ['name' => 'Participate in Voting', 'slug' => 'participate_voting'],
            ['name' => 'View Post Game Summary', 'slug' => 'view_post_game_summary'],
            ['name' => 'Host Game', 'slug' => 'host_game'],
            ['name' => 'Configure Game', 'slug' => 'configure_game'],
            ['name' => 'Manage Players', 'slug' => 'manage_players'],
            ['name' => 'Assign Host Privileges', 'slug' => 'assign_host_privileges'],
            ['name' => 'Manage Users', 'slug' => 'manage_users'],
            ['name' => 'Manage Roles', 'slug' => 'manage_roles'],
            ['name' => 'Manage Permissions', 'slug' => 'manage_permissions'],
            ['name' => 'Access Server Settings', 'slug' => 'access_server_settings'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['slug' => $permission['slug']], $permission);
        }

        // Create roles and assign permissions
        $guest = Role::firstOrCreate(
            ['slug' => 'guest'],
            [
                'name' => 'Guest',
                'description' => 'User who has not logged in'
            ]
        );
        $guest->permissions()->sync(Permission::whereIn('slug', [
            'view_public_content',
            'join_game'
        ])->get());

        $player = Role::firstOrCreate(
            ['slug' => 'player'],
            [
                'name' => 'Player',
                'description' => 'Registered player user'
            ]
        );
        $player->permissions()->sync(Permission::whereIn('slug', [
            'view_public_content',
            'join_game',
            'view_game_content',
            'play_game',
            'participate_voting',
            'view_post_game_summary'
        ])->get());

        $host = Role::firstOrCreate(
            ['slug' => 'host'],
            [
                'name' => 'Host',
                'description' => 'Game host user'
            ]
        );
        $host->permissions()->sync(Permission::whereIn('slug', [
            'host_game',
            'configure_game',
            'manage_players',
            'assign_host_privileges'
        ])->get());

        $admin = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Admin',
                'description' => 'System administrator'
            ]
        );
        $admin->permissions()->sync(Permission::all());
    }
}
