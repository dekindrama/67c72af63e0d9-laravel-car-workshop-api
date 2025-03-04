<?php

namespace App\Http\Controllers\Auth;

use App\Enums\ResponseStatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    function login(Request $request) : JsonResponse {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken($request->email);

            return response()->json([
                'message' => 'succes to login',
                'data' => [
                    'token' => $token->plainTextToken,
                ],
            ]);
        }

        return response()->json([
                'message' => 'account not found',
            ], Response::HTTP_NOT_FOUND);
    }

    function loggedUser(Request $request) : JsonResponse {

        return response()->json([
            'message' => 'success get logged user',
            'data' => [
                'user' => $request->user(),
            ],
        ]);
    }

    function logout(Request $request) : JsonResponse {
        $user = Auth::user();

        $user->tokens()->delete();

        return response()->json([
            'message' => 'succes to logout',
        ]);
    }
}
