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
        Schema::create('certificate_tuitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tuition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('certificate_id')->constrained()->cascadeOnDelete();
            $table->decimal('price_in_person', 12, 2)->nullable();
            $table->decimal('price_virtual', 12, 2)->nullable();
            $table->decimal('price_electronic', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_tuitions');
    }
};
