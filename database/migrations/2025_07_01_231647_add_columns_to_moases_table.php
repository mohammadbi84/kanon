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
        Schema::table('moases', function (Blueprint $table) {
            $table->string('tamas')->nullable()->after('mobile');
            $table->string('email')->nullable()->after('tamas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('moases', function (Blueprint $table) {
            $table->dropColumn('tamas');
            $table->dropColumn('email');
        });
    }
};
