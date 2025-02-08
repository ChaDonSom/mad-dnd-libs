<?php

namespace App\Http\Controllers\Api;

use App\Models\User;

class UserController extends ApiController
{
    protected $model = User::class;

    public function includes(): array
    {
        return ['roles'];
    }
}
