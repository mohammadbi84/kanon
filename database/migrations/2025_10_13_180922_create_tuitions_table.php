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
        Schema::create('tuitions', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان شهریه
            $table->foreignId('city_id')->constrained('cities','id')->cascadeOnDelete(); // شهر مربوطه
            $table->date('start_date')->nullable(); // تاریخ شروع بازه
            $table->date('end_date')->nullable();   // تاریخ پایان بازه
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuitions');
    }
};
