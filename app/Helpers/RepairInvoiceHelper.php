<?php

namespace App\Helpers;

use App\Entities\OwnerEntity;
use App\Entities\ServiceEntity;
use App\Entities\SummaryInvoiceEntity;
use App\Models\Repair;

class RepairInvoiceHelper
{
    static function setSummary(Repair $repair) : SummaryInvoiceEntity {
        $summary = SummaryInvoiceEntity::make();

        $owner = $repair->owner;
        $summary->owner = OwnerEntity::make()->fromArray([
            'name' => $owner->name,
            'email' => $owner->email,
        ]);

        $car = $repair->car;
        $summary->car_number_plate = $car->number_plate;

        $services = [];
        $totalPrice = 0;
        foreach ($repair->jobs as $index => $job) {
            $services[$index] = ServiceEntity::make()->fromArray([
                'name' => $job->service->name,
                'price' => $job->service->price,
            ]);

            $totalPrice += $job->service->price;
        }
        $summary->services = collect($services);
        $summary->total_price = $totalPrice;

        return $summary;
    }
}
