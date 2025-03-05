<?php

namespace App\Http\Controllers\Admin\Repair;

use App\Enums\RoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Repair\RepairJobStoreRequest;
use App\Http\Requests\Admin\Repair\RepairJobUpdateRequest;
use App\Models\Repair;
use App\Models\RepairJob;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RepairJobController extends Controller
{
    function index(int $id) : JsonResponse {
        $repair = Repair::query()
            ->with('jobs', 'jobs.service')
            ->where('id', $id)
            ->first();
        abort_if($repair == null, Response::HTTP_NOT_FOUND, 'repair not found');

        $jobs = $repair->jobs;

        return response()->json([
            'message' => 'success get jobs',
            'data' => [
                'jobs' => $jobs->map(function($job) {
                    return [
                        'id' => $job->id,
                        'status' => $job->status,
                        'service' => $job->service->only('id', 'name'),
                    ];
                }),
            ],
        ], Response::HTTP_OK);
    }

    function store(RepairJobStoreRequest $request) : JsonResponse {
        $repair = Repair::query()
            ->with('jobs', 'jobs.service')
            ->where('id', $request->id)
            ->first();
        abort_if($repair == null, Response::HTTP_NOT_FOUND, 'repair not found');

        if ($request->mechanic_id) {
            $mechanic = User::query()
                ->where('id', $request->mechanic_id)
                ->where('role', RoleEnum::MECHANIC)
                ->first();
            abort_if($mechanic == null, Response::HTTP_NOT_FOUND, 'mechanic not found');
        }

        $service = Service::query()
            ->where('id', $request->service_id)
            ->first();
        abort_if($service == null, Response::HTTP_NOT_FOUND, 'service not found');

        $storedJob = $repair->jobs()->create([
            'service_id' => $request->service_id,
            'mechanic_id' => $request->mechanic_id,
            'repair_id' => $request->id,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'success store repair job',
            'data' => [
                'job' => $storedJob->only('id', 'status'),
            ],
        ], Response::HTTP_CREATED);
    }

    function update(RepairJobUpdateRequest $request) : JsonResponse {
        $repair = Repair::query()
            ->with('jobs', 'jobs.service')
            ->where('id', $request->id)
            ->first();
        abort_if($repair == null, Response::HTTP_NOT_FOUND, 'repair not found');

        if ($request->mechanic_id) {
            $mechanic = User::query()
                ->where('id', $request->mechanic_id)
                ->where('role', RoleEnum::MECHANIC)
                ->first();
            abort_if($mechanic == null, Response::HTTP_NOT_FOUND, 'mechanic not found');
        }

        $service = Service::query()
            ->where('id', $request->service_id)
            ->first();
        abort_if($service == null, Response::HTTP_NOT_FOUND, 'service not found');

        $job = RepairJob::query()
            ->where('id', $request->repair_job_id)
            ->first();
        abort_if($job == null, Response::HTTP_NOT_FOUND, 'job not found');

        $job->update([
            'service_id' => $request->service_id,
            'mechanic_id' => $request->mechanic_id,
            'repair_id' => $request->id,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'success update repair job',
            'data' => [
                'job' => $job->only('id', 'status'),
            ],
        ], Response::HTTP_OK);
    }

    function destroy(Request $request) : JsonResponse {
        $job = RepairJob::find($request->repair_job_id);
        abort_if($job == null, Response::HTTP_NOT_FOUND, 'job not found');

        $job->delete();

        return response()->json([
            'message' => 'success delete repair job',
        ], Response::HTTP_OK);
    }
}
