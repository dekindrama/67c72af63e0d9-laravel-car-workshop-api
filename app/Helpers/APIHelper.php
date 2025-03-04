<?php

namespace App\Helpers;

class APIHelper
{
    static function getHeaders() : array {
        return [
            'Accept' => "application/json",
            'Content-Type' => "application/json",
        ];
    }
}
