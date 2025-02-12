<?php

namespace App\Http\Controllers\Api;

use App\Models\Permission;
use Orion\Http\Controllers\Controller;

class PermissionController extends Controller
{
    protected $model = Permission::class;

    public function includes(): array
    {
        return ['roles'];
    }
}
