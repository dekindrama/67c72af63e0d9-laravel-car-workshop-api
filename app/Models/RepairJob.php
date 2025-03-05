<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairJob extends Model
{
    /** @use HasFactory<\Database\Factories\RepairJobFactory> */
    use HasFactory;

    protected $table = 'repair_jobs';

    protected $fillable = [
        'repair_id',
        'service_id',
        'mechanic_id',
        'status',
    ];

    function repair() : BelongsTo {
        return $this->belongsTo(Repair::class, 'repair_id', 'id');
    }

    function mechanic() : BelongsTo {
        return $this->belongsTo(User::class, 'mechanic_id', 'id');
    }

    function service() : BelongsTo {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
