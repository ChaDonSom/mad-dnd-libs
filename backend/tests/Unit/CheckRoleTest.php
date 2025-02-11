<?php

namespace Tests\Unit;

use App\Http\Middleware\CheckRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CheckRoleTest extends TestCase
{
    public function test_handle_with_valid_role()
    {
        $request = new Request();
        $middleware = new CheckRole();
        $user = Mockery::mock(User::class);

        $user->shouldReceive('hasRole')
            ->once()
            ->with('admin')
            ->andReturn(true);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($user);

        $response = $middleware->handle($request, fn($req) => new Response('OK'), 'admin');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_handle_with_invalid_role()
    {
        $request = new Request();
        $middleware = new CheckRole();
        $user = Mockery::mock(User::class);

        $user->shouldReceive('hasRole')
            ->once()
            ->with('admin')
            ->andReturn(false);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($user);

        $response = $middleware->handle($request, fn($req) => new Response('OK'), 'admin');

        $this->assertEquals(403, $response->getStatusCode());
    }
}
