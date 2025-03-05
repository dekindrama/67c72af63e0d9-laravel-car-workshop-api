<?php

namespace App\Enums;

class RoleEnum
{
    const ADMIN = "ADMIN";
    const MECHANIC = "MECHANIC";
    const CAR_OWNER = "CAR_OWNER";

    static function getRoles() : array {
        return [
            Self::ADMIN,
            Self::MECHANIC,
            Self::CAR_OWNER,
        ];
    }
}
