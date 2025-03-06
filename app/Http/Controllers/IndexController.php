<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request) : JsonResponse
    {
        return response()->json([
            'message' => 'success hit car workshop api',
        ], Response::HTTP_OK);
    }
}
