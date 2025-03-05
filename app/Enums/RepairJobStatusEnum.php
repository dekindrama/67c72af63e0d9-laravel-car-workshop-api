<?php

namespace App\Enums;

class RepairJobStatusEnum
{
    const UNASSIGNED = "UNASSIGNED";
    const PROGRESS = "PROGRESS";
    const COMPLETED = "COMPLETED";

    static function get() : array {
        return [
            Self::UNASSIGNED,
            Self::PROGRESS,
            Self::COMPLETED,
        ];
    }
}
