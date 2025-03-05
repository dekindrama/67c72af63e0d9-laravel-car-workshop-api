<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    function index() : JsonResponse {
        $users = User::query()
            ->select('id', 'name', 'email', 'role')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'success get users',
            'data' => [
                'users' => $users,
            ],
        ], Response::HTTP_OK);
    }

    function store(UserStoreRequest $request) : JsonResponse {
        $storedUser = User::create($request->validated());

        return response()->json([
            'message' => 'success store user',
            'data' => [
                'user' => $storedUser,
            ],
        ], Response::HTTP_CREATED);
    }

    function destroy(int $id) : JsonResponse {
        $user = User::find($id);
        abort_if($user == null, Response::HTTP_NOT_FOUND, 'user not found');

        $user->delete();

        return response()->json([
            'message' => 'success delete user',
        ], Response::HTTP_OK);
    }
}
