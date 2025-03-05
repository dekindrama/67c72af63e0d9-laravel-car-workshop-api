<?php

namespace App\Http\Controllers\Mechanic\Job;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mechanic\Job\JobUpdateResource;
use App\Http\Resources\Mechanic\Job\JobDetailResource;
use App\Http\Resources\Mechanic\Job\JobListResource;
use App\Models\RepairJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    function index() : JsonResponse {
        $jobs = RepairJob::query()
            ->with('repair', 'repair.car', 'service')
            ->where('mechanic_id', Auth::user()->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'success get jobs',
            'data' => [
                'jobs' => JobListResource::collection($jobs),
            ],
        ], Response::HTTP_OK);
    }

    function show(int $id) : JsonResponse {
        $job = RepairJob::query()
            ->with('repair', 'repair.car', 'service')
            ->where('mechanic_id', Auth::user()->id)
            ->where('id', $id)
            ->first();
        abort_if($job == null, Response::HTTP_NOT_FOUND, 'job not found');

        return response()->json([
            'message' => 'success get job',
            'data' => [
                'job' => JobDetailResource::make($job),
            ],
        ], Response::HTTP_OK);
    }

    function update(JobUpdateResource $request) : JsonResponse {
        $job = RepairJob::query()
            ->with('repair', 'repair.car', 'service')
            ->where('mechanic_id', Auth::user()->id)
            ->where('id', $request->id)
            ->first();
        abort_if($job == null, Response::HTTP_NOT_FOUND, 'job not found');

        $job->update($request->validated());

        return response()->json([
            'message' => 'success update job',
            'data' => [
                'job' => JobDetailResource::make($job),
            ],
        ], Response::HTTP_OK);
    }
}
