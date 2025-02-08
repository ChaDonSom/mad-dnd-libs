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
            Permission::create($permission);
        }

        // Create roles and assign permissions
        $guest = Role::create([
            'name' => 'Guest',
            'slug' => 'guest',
            'description' => 'User who has not logged in'
        ]);
        $guest->permissions()->attach(Permission::whereIn('slug', [
            'view_public_content',
            'join_game'
        ])->get());

        $player = Role::create([
            'name' => 'Player',
            'slug' => 'player',
            'description' => 'Registered player user'
        ]);
        $player->permissions()->attach(Permission::whereIn('slug', [
            'view_public_content',
            'join_game',
            'view_game_content',
            'play_game',
            'participate_voting',
            'view_post_game_summary'
        ])->get());

        $host = Role::create([
            'name' => 'Host',
            'slug' => 'host',
            'description' => 'Game host user'
        ]);
        $host->permissions()->attach(Permission::whereIn('slug', [
            'host_game',
            'configure_game',
            'manage_players',
            'assign_host_privileges'
        ])->get());

        $admin = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'System administrator'
        ]);
        $admin->permissions()->attach(Permission::all());
    }
}
