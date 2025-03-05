<?php

namespace App\Http\Resources\CarOwner\Repair;

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
            'car' => $this->car->only('id', 'number_plate', 'description'),
        ];
    }
}
