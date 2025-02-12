<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Orion\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $model = User::class;

    protected function beforeSave($request, $user)
    {
        if ($request->has('roles')) {
            $user->roles()->sync($request->input('roles'));
        }
        return $user;
    }
}
