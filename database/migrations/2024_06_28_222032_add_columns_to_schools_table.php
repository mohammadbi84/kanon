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
            $table->text('number');
            $table->text('sodor_num');
            $table->text('sodor_start');
            $table->text('sodor_end');
            $table->text('address');
            $table->text('tel');
            $table->text('fax');
            $table->text('mobile');
            $table->text('email');
            $table->text('site');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organs', function (Blueprint $table) {
            //
            $table->dropColumn('number');
            $table->dropColumn('sodor_num');
            $table->dropColumn('sodor_start');
            $table->dropColumn('sodor_end');
            $table->dropColumn('address');
            $table->dropColumn('tel');
            $table->dropColumn('fax')->nullable();
            $table->dropColumn('mobile');
            $table->dropColumn('email')->nullable();
            $table->dropColumn('site')->nullable();
        });
    }
};
