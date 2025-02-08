<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ExampleGameController extends Controller
{
    public function getTemplates(): JsonResponse
    {
        return response()->json([
            'templates' => [
                // Placeholder data
                ['id' => 1, 'name' => 'Tavern Adventure'],
                ['id' => 2, 'name' => 'Dragon Quest'],
            ]
        ]);
    }

    public function getStory($id): JsonResponse
    {
        return response()->json([
            'story' => [
                'id' => $id,
                'title' => 'Sample Story',
                'content' => 'This is a placeholder story content.'
            ]
        ]);
    }
}
