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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('field_id')->constrained()->cascadeOnDelete(); // رشته
            $table->string('name'); // عنوان
            $table->string('standard_code'); // کد استاندارد
            $table->string('group_title')->nullable(); // عنوان سرگروه
            $table->foreignId('jobtype_id')->nullable()->constrained()->cascadeOnDelete();
            $table->integer('duration_hour')->default(0); // مدت زمانی - ساعت
            $table->integer('duration_minute')->default(0); // مدت زمانی - دقیقه
            $table->boolean('is_archived')->default(false); // آرشیو یا عدم آرشیو
            $table->date('draft_date')->nullable(); // تاریخ تدوین
            $table->string('file_path')->nullable(); // لینک دانلود استاندارد

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
