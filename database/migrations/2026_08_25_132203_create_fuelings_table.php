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
        Schema::create('fuelings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehicle_id')->constrained()->cascadeOnDelete();
            $table->date('fueling_date');
            $table->decimal('liters', 8, 2);
            $table->decimal('price_per_liter', 10, 2);
            $table->decimal('total_cost', 12, 2);
            $table->string('currency', 3)->default('HUF');
            $table->unsignedInteger('odometer');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuelings');
    }
};
