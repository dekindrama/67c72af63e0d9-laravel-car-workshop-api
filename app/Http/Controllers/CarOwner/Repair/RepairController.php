<?php

namespace App\Http\Controllers\CarOwner\Repair;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarOwner\Repair\RepairDetailResource;
use App\Http\Resources\CarOwner\Repair\RepairListResource;
use App\Models\Repair;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RepairController extends Controller
{
    function index() : JsonResponse {
        $repairs = Repair::query()
            ->with('car')
            ->where('owner_id', Auth::user()->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'success get repairs',
            'data' => [
                'repairs' => RepairListResource::collection($repairs),
            ],
        ], Response::HTTP_OK);
    }

    function show(int $id) : JsonResponse {
        $repair = Repair::query()
            ->with('car', 'jobs', 'jobs.mechanic', 'jobs.service')
            ->where('owner_id', Auth::user()->id)
            ->where('id', $id)
            ->first();
        abort_if($repair == null, Response::HTTP_NOT_FOUND, 'repair not found');

        return response()->json([
            'message' => 'success get repair',
            'data' => [
                'repair' => RepairDetailResource::make($repair),
            ],
        ], Response::HTTP_OK);
    }
}
