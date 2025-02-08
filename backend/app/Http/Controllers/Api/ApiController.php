<?php

namespace App\Http\Controllers\Api;

use Orion\Http\Controllers\Controller;

abstract class ApiController extends Controller
{
    protected function beforeSave($request, $model)
    {
        return $model;
    }

    protected function afterSave($request, $model)
    {
        return $model;
    }
}
