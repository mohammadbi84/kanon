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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // popup, slider, bookmark ...
            $table->string('slug')->unique();
            $table->unsignedInteger('max_slots')->nullable();
            $table->boolean('is_ordered')->default(false);
            $table->json('settings')->nullable(); // تنظیمات خاص هر جایگاه
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
