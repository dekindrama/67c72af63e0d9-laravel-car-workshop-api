<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Service\ServiceStoreRequest;
use App\Http\Requests\Admin\Service\ServiceUpdateRequest;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    function index() : JsonResponse {
        $services = Service::query()
            ->select('id', 'name', 'price')
            ->latest()
            ->get();

        return response()->json([
            'message' => 'success get services',
            'data' => [
                'services' => $services,
            ],
        ], Response::HTTP_OK);
    }

    function store(ServiceStoreRequest $request) : JsonResponse {
        $storedService = Service::create($request->validated());

        return response()->json([
            'message' => 'success store service',
            'data' => [
                'service' => $storedService->only('id', 'name', 'price'),
            ],
        ], Response::HTTP_CREATED);
    }

    function update(ServiceUpdateRequest $request) : JsonResponse {
        $service = Service::find($request->id);
        abort_if($service == null, Response::HTTP_NOT_FOUND, 'service not found');

        $service->update($request->validated());

        return response()->json([
            'message' => 'success update service',
            'data' => [
                'service' => $service->only('id', 'name', 'price'),
            ],
        ], Response::HTTP_OK);
    }

    function destroy(int $id) : JsonResponse {
        $service = Service::find($id);
        abort_if($service == null, Response::HTTP_NOT_FOUND, 'service not found');

        $service->delete();

        return response()->json([
            'message' => 'success delete service',
        ], Response::HTTP_OK);
    }
}
