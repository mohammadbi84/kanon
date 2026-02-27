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
        Schema::create('advertisement_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertisement_id')->constrained()->cascadeOnDelete();
            $table->foreignId('position_id')->constrained()->cascadeOnDelete();

            $table->date('date');
            $table->unsignedInteger('slot_number');

            $table->decimal('price', 15, 2);

            $table->enum('status', [
                'reserved',
                'awaiting_payment',
                'paid',
                'cancelled'
            ])->default('reserved');

            $table->timestamp('payment_expires_at')->nullable();

            $table->timestamps();

            $table->unique(['position_id', 'date', 'slot_number']);
            $table->index(['position_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisement_reservations');
    }
};
