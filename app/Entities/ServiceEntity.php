<?php

namespace App\Entities;

class ServiceEntity
{
    public string $name;
    public int $price;

    static function make() : Self {
        return new Self();
    }

    function fromArray(array $data) : Self {
        $this->name = $data['name'];
        $this->price = $data['price'];

        return $this;
    }

    function fromJson(object $json) : Self {
        $this->name = $json->name;
        $this->price = $json->price;

        return $this;
    }
}
