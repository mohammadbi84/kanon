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
        Schema::table('tuition_imports', function (Blueprint $table) {
            $table->foreignId('tuition_id')->after('id')->nullable()->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tuition_imports', function (Blueprint $table) {
            $table->dropColumn('tuition_id');
            $table->dropForeign('tuition_id');
        });
    }
};
