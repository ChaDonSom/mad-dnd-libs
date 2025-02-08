<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\Model;
use Orion\Http\Controllers\Controller;
use Orion\Http\Requests\Request;

abstract class ApiController extends Controller
{
    /**
     * Check if the authenticated user has the required permission
     */
    protected function hasPermission(string $permission): bool
    {
        return auth()->user()->can($permission);
    }

    /**
     * Check if the authenticated user has the required role
     */
    protected function hasRole(string $role): bool
    {
        return auth()->user()->hasRole($role);
    }

    protected function beforeSave(Request $request, Model $model)
    {
        return $model;
    }

    protected function afterSave(Request $request, Model $model)
    {
        return $model;
    }
}
