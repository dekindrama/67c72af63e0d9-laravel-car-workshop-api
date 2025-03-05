<?php

namespace App\Http\Resources\Mechanic\Job;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobDetailResource extends JsonResource
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
            'car' => $this->repair->car->only('number_plate', 'description'),
            'service' => $this->service->only('id', 'name'),
            'status' => $this->status,
        ];
    }
}
