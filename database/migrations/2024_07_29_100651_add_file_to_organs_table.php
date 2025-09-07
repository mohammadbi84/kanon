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
        Schema::table('organs', function (Blueprint $table) {
            //
            $table->text('file_moases')->nullable();
            $table->text('file_logo')->nullable();
            $table->text('file_tasis')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organs', function (Blueprint $table) {
            //
        });
    }
};
