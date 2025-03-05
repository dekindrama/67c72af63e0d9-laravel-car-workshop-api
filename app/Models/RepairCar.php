<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairCar extends Model
{
    /** @use HasFactory<\Database\Factories\RepairCarFactory> */
    use HasFactory;

    protected $table = 'repair_cars';

    protected $fillable = [
        'repair_id',
        'number_plate',
        'description',
    ];

    function repair() : BelongsTo {
        return $this->belongsTo(Repair::class, 'repair_id', 'id');
    }
}
