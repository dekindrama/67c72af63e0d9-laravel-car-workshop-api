<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndexController extends Controller
{
    function index() : JsonResponse {
        return response()->json([
            'message' => 'success hit car workshop api',
        ], Response::HTTP_OK);
    }
}
