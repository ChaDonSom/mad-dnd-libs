<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserRolePermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create permissions
        $permissions = [
            Permission::create(['name' => 'View Public Content', 'slug' => 'view_public_content']),
            Permission::create(['name' => 'Join Game', 'slug' => 'join_game']),
            Permission::create(['name' => 'Host Game', 'slug' => 'host_game']),
            Permission::create(['name' => 'Manage Users', 'slug' => 'manage_users']),
        ];

        // Create roles
        $playerRole = Role::create(['name' => 'Player', 'slug' => 'player']);
        $hostRole = Role::create(['name' => 'Host', 'slug' => 'host']);
        $adminRole = Role::create(['name' => 'Admin', 'slug' => 'admin']);

        // Assign permissions to roles
        $playerRole->permissions()->attach([$permissions[0]->id, $permissions[1]->id]);
        $hostRole->permissions()->attach([$permissions[0]->id, $permissions[1]->id, $permissions[2]->id]);
        $adminRole->permissions()->attach(collect($permissions)->pluck('id')->toArray());
    }

    public function test_user_can_have_roles()
    {
        $user = User::factory()->create();
        $role = Role::where('slug', 'player')->first();
        
        $user->roles()->attach($role);
        
        $this->assertTrue($user->hasRole('player'));
        $this->assertFalse($user->hasRole('admin'));
    }

    public function test_user_can_have_permissions_through_roles()
    {
        $user = User::factory()->create();
        $role = Role::where('slug', 'host')->first();
        
        $user->roles()->attach($role);
        
        $this->assertTrue($user->hasPermission('view_public_content'));
        $this->assertTrue($user->hasPermission('join_game'));
        $this->assertTrue($user->hasPermission('host_game'));
        $this->assertFalse($user->hasPermission('manage_users'));
    }

    public function test_admin_has_all_permissions()
    {
        $user = User::factory()->create();
        $role = Role::where('slug', 'admin')->first();
        
        $user->roles()->attach($role);
        
        $this->assertTrue($user->hasPermission('view_public_content'));
        $this->assertTrue($user->hasPermission('join_game'));
        $this->assertTrue($user->hasPermission('host_game'));
        $this->assertTrue($user->hasPermission('manage_users'));
        $this->assertTrue($user->isAdmin());
    }

    public function test_register_assigns_player_role()
    {
        // Create player role if it doesn't exist
        if (!Role::where('slug', 'player')->exists()) {
            Role::create(['name' => 'Player', 'slug' => 'player']);
        }

        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'token',
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'roles' => [
                            '*' => [
                                'id',
                                'name', 
                                'slug'
                            ]
                        ]
                    ]
                ]);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        
        $user = User::where('email', 'test@example.com')->first();
        $this->assertTrue($user->hasRole('player'));
    }

    public function test_login_includes_roles_and_permissions()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
        
        $role = Role::where('slug', 'player')->first();
        $user->roles()->attach($role);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'token',
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'roles' => [
                            '*' => [
                                'id',
                                'name',
                                'slug',
                                'permissions' => [
                                    '*' => [
                                        'id',
                                        'name',
                                        'slug'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]);
    }
}