<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

class UserController extends ApiController
{
    protected $model = User::class;

    public function includes(): array
    {
        return ['roles', 'permissions'];
    }

    protected function beforeSave($request, $user)
    {
        if ($request->has('roles')) {
            $user->roles()->sync($request->input('roles'));
        }
        return $user;
    }
}
