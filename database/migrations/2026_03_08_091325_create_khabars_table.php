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
        Schema::create('khabars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('status')->default(false);
            $table->longText('body');
            $table->string('cover')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khabars');
    }
};
