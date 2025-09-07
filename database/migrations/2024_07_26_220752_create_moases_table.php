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
        Schema::create('moases', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('family')->nullable();
            $table->text('national_code')->nullable();
            $table->text('gender')->nullable();
            $table->text('father')->nullable();
            $table->text('shenasname')->nullable();
            $table->text('birthday')->nullable();
            $table->text('sadere')->nullable();
            $table->text('sherkat_name')->nullable();
            $table->text('sherkat_sab')->nullable();
            $table->text('sherkat_tarikh')->nullable();
            $table->text('sherkat_modir')->nullable();
            $table->bigInteger('organ_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moases');
    }
};
