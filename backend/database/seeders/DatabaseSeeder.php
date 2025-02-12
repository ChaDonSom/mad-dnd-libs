<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
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
            Permission::firstOrCreate($permission);
        }

        // Create roles with permissions
        $roleDefinitions = [
            ['name' => 'Administrator', 'slug' => 'admin'],
            ['name' => 'Host', 'slug' => 'host'],
            ['name' => 'Player', 'slug' => 'player'],
        ];

        $rolePermissions = [
            'admin' => Permission::all(),
            'host' => Permission::whereIn('slug', [
                'view_public_content',
                'join_game',
                'view_game_content',
                'play_game',
                'participate_voting',
                'view_post_game_summary',
                'host_game',
                'configure_game',
                'manage_players',
                'assign_host_privileges',
            ])->get(),
            'player' => Permission::whereIn('slug', [
                'view_public_content',
                'join_game',
                'view_game_content',
                'play_game',
                'participate_voting',
                'view_post_game_summary',
            ])->get(),
        ];

        foreach ($roleDefinitions as $roleDef) {
            $role = Role::firstOrCreate([
                'slug' => $roleDef['slug']
            ], [
                'name' => $roleDef['name'],
                'slug' => $roleDef['slug']
            ]);

            $role->permissions()->sync($rolePermissions[$roleDef['slug']]);
        }

        // Create test users if in development
        if (app()->environment('local')) {
            $testUsers = [
                [
                    'name' => 'Admin User',
                    'email' => 'admin@example.com',
                    'password' => bcrypt('password123'),
                    'role' => 'admin',
                ],
                [
                    'name' => 'Host User',
                    'email' => 'host@example.com',
                    'password' => bcrypt('password123'),
                    'role' => 'host',
                ],
                [
                    'name' => 'Player User',
                    'email' => 'player@example.com',
                    'password' => bcrypt('password123'),
                    'role' => 'player',
                ],
            ];

            foreach ($testUsers as $userData) {
                $role = $userData['role'];
                unset($userData['role']);

                $user = User::firstOrCreate(
                    ['email' => $userData['email']],
                    $userData
                );

                $user->roles()->sync([Role::where('slug', $role)->first()->id]);
            }
        }
    }
}
