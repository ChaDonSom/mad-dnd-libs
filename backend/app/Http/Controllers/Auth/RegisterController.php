<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Assign default player role
        $playerRole = Role::where('slug', 'player')->first();
        $user->roles()->attach($playerRole);

        // Include roles and permissions in token abilities
        $abilities = $playerRole->permissions()->pluck('slug')->toArray();
        $token = $user->createToken('auth-token', $abilities);

        return response()->json([
            'token' => $token->plainTextToken,
            'user' => $user->load('roles.permissions'),
        ], 201);
    }
}
