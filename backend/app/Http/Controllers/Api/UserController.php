<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Orion\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $model = User::class;

    public function includes(): array
    {
        return ['roles', 'roles.permissions'];
    }

    protected function beforeSave($request, $user)
    {
        if ($request->has('roles')) {
            $user->roles()->sync($request->input('roles'));
        }
        return $user;
    }
}
