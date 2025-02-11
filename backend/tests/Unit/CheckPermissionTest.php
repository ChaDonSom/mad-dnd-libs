<?php

namespace Tests\Unit;

use App\Http\Middleware\CheckPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CheckPermissionTest extends TestCase
{
    public function test_handle_with_valid_permission()
    {
        $request = new Request();
        $middleware = new CheckPermission();
        $user = Mockery::mock(User::class);

        $user->shouldReceive('hasPermission')
            ->once()
            ->with('view_content')
            ->andReturn(true);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($user);

        $response = $middleware->handle($request, fn($req) => new Response('OK'), 'view_content');

        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_handle_with_invalid_permission()
    {
        $request = new Request();
        $middleware = new CheckPermission();
        $user = Mockery::mock(User::class);

        $user->shouldReceive('hasPermission')
            ->once()
            ->with('view_content')
            ->andReturn(false);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($user);

        $response = $middleware->handle($request, fn($req) => new Response('OK'), 'view_content');

        $this->assertEquals(403, $response->getStatusCode());
    }
}
