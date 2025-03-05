<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Repair extends Model
{
    /** @use HasFactory<\Database\Factories\RepairFactory> */
    use HasFactory;

    protected $table = 'repairs';

    protected $fillable = [
        'owner_id',
        'status',
        'arrived_at',
    ];

    function owner() : BelongsTo {
        return $this->BelongsTo(User::class, 'owner_id', 'id');
    }

    function car() : HasOne {
        return $this->hasOne(RepairCar::class, 'repair_id', 'id');
    }

    function jobs() : HasMany {
        return $this->hasMany(RepairJob::class, 'repair_id', 'id');
    }
}
