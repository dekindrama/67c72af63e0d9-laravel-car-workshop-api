<?php

namespace App\Http\Resources\Admin\Repair;

use App\Entities\SummaryInvoiceEntity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepairInvoiceDetailResource extends JsonResource
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
            'summary' => SummaryInvoiceEntity::make()->fromJsonString($this->summary),
            'paid_at' => $this->paid_at,
        ];
    }
}
