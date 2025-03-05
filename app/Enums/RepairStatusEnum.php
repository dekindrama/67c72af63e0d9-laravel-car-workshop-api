<?php

namespace App\Enums;

class RepairStatusEnum
{
    const PROGRESS = "PROGRESS";
    const COMPLETED = "COMPLETED";

    static function get() : array {
        return [
            Self::PROGRESS,
            Self::COMPLETED,
        ];
    }
}
