<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Orion\Http\Controllers\Controller;

class RoleController extends Controller
{
    protected $model = Role::class;

    /**
     * The relations that can be included in the response.
     *
     * @return array
     */
    public function includes(): array
    {
        return ['permissions'];
    }
}
