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
            $table->tinyInteger('tabsare34');
            $table->tinyInteger('baradaran');
            $table->tinyInteger('khaharan');
            $table->bigInteger('state');
            $table->bigInteger('city');
            $table->text('postal');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('organs', function (Blueprint $table) {
            //
            $table->dropColumn('tabsare34')->default(0);
            $table->dropColumn('baradaran')->default(0);
            $table->dropColumn('khaharan')->default(0);
            $table->dropColumn('state');
            $table->dropColumn('city');
            $table->dropColumn('postal');
        });
    }
};
