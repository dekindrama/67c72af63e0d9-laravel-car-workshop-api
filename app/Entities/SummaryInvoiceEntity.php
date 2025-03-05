<?php

namespace App\Entities;

use Illuminate\Support\Collection;

class SummaryInvoiceEntity
{
    public OwnerEntity $owner;
    public Collection $services; //* []ServiceEntity
    public string $car_number_plate;
    public int $total_price;

    static function make() : Self {
        return new Self();
    }

    function fromJsonString(string $jsonString) : Self {
        $json = json_decode($jsonString);

        $this->owner = OwnerEntity::make()->fromJson($json->owner);
        $this->services = collect($json->services)->map(function ($data) {
            return ServiceEntity::make()->fromJson($data);
        });
        $this->car_number_plate = $json->car_number_plate;
        $this->total_price = $json->total_price;

        return $this;
    }

    function toJsonString() : string {
        return json_encode($this);
    }
}
