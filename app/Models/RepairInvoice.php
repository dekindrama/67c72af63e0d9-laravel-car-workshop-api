<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairInvoice extends Model
{
    /** @use HasFactory<\Database\Factories\RepairInvoiceFactory> */
    use HasFactory;

    protected $table = 'repair_invoices';

    protected $fillable = [
        'repair_id',
        'summary',
        'paid_at',
    ];

    function repair() : BelongsTo {
        return $this->belongsTo(Repair::class, 'repair_id', 'id');
    }
}
