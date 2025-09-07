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
        Schema::create('herves', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('group_id');
            $table->string('name');
            $table->string('old_code');
            $table->string('code');
            $table->time('theory_time');
            $table->time('amali_time');
            $table->time('karvarzi_time');
            $table->time('project_time');
            $table->time('total_time');
            $table->bigInteger('type_id');
            $table->bigInteger('kardanesh_id');
            $table->bigInteger('min_tahsil_id');
            $table->string('slahiat_morabi');
            $table->tinyInteger('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('herves');
    }
};
