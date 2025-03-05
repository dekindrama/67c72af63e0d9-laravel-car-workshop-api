<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repair_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->longtext('summary');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_invoices');
    }
};
