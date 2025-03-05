<?php

namespace App\Http\Resources\Admin\Repair;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepairListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'arrived_at' => $this->arrived_at,
            'owner' => $this->owner->only('id', 'name', 'email'),
            'jobs' => $this->jobs->map(function($job) {
                return [
                    'id' => $job->id,
                    'status' => $job->status,
                    'service' => $job->service->only('id', 'name'),
                ];
            }),
        ];
    }
}
