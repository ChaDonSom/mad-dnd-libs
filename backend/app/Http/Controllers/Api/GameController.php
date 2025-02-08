<?php

namespace App\Http\Controllers\API;

use App\Models\Game;
use App\Http\Controllers\Api\ApiController;

class GameController extends ApiController
{
    protected $model = Game::class;
}
