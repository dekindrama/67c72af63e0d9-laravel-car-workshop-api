<?php

namespace App\Entities;

class OwnerEntity
{
    public string $name;
    public string $email;

    static function make() : Self {
        return new Self();
    }

    function fromArray(array $data) : Self {
        $this->name = $data['name'];
        $this->email = $data['email'];

        return $this;
    }

    function fromJson(object $json) : Self {
        $this->name = $json->name;
        $this->email = $json->email;

        return $this;
    }
}
