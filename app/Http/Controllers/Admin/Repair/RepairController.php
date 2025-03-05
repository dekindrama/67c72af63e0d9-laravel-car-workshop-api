<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Repair\RepairStoreRequest;
use App\Http\Requests\Admin\Repair\RepairUpdateRequest;
use App\Http\Resources\Admin\Repair\RepairListResource;
use App\Models\Repair;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RepairController extends Controller
{
    function index() : JsonResponse {
        $repairs = Repair::query()
            ->with('owner', 'car', 'jobs', 'jobs.service')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'success get repairs',
            'data' => [
                'repairs' => RepairListResource::collection($repairs),
            ],
        ], Response::HTTP_OK);
    }

    function store(RepairStoreRequest $request) : JsonResponse {
        DB::beginTransaction();

        try {
            $storedRepair = Repair::create([
                'owner_id' => $request->owner_id,
                'status' => $request->status,
                'arrived_at' => now(),
            ]);

            $storedRepairCar = $storedRepair->car()->create([
                'number_plate' => $request->car_number_plate,
                'description' => $request->car_description,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return response()->json([
            'message' => 'success store repair',
            'data' => [
                'repair' => $storedRepair->only('id', 'status', 'arrived_at'),
            ],
        ], Response::HTTP_CREATED);
    }

    function update(RepairUpdateRequest $request) : JsonResponse {
        DB::beginTransaction();

        try {
            $repair = Repair::find($request->id);
            abort_if($repair == null, Response::HTTP_NOT_FOUND, 'repair not found');

            $repair->update([
                'owner_id' => $request->owner_id,
                'status' => $request->status,
            ]);

            $updatedCar = $repair->car()->update([
                'number_plate' => $request->car_number_plate,
                'description' => $request->car_description,
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return response()->json([
            'message' => 'success update repair',
            'data' => [
                'repair' => $repair->only('id', 'status', 'arrived_at'),
            ],
        ], Response::HTTP_OK);
    }

    function destroy(int $id) : JsonResponse {
        $repair = Repair::find($id);
        abort_if($repair == null, Response::HTTP_NOT_FOUND, 'repair not found');

        $repair->delete();

        return response()->json([
            'message' => 'success delete repair',
        ], Response::HTTP_OK);
    }
}
