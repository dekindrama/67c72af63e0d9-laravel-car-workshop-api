<?php

namespace App\Enums;

class RoleEnum
{
    const ADMIN = "ADMIN";
    const MECHANIC = "MECHANIC";
    const CAR_OWNER = "CAR_OWNER";

    static function get() : array {
        return [
            Self::ADMIN,
            Self::MECHANIC,
            Self::CAR_OWNER,
        ];
    }
}
