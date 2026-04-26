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
        Schema::create('tuition_import_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tuition_import_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->boolean('success')->default(false);
            $table->integer('row_number')->nullable();
            $table->text('error_message');
            $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tuition_import_logs');
    }
};
