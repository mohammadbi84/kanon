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
        Schema::create('professions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('field_id')->constrained()->cascadeOnDelete(); // رشته
            $table->string('name'); // نام استاندارد (حرفه)
            $table->string('old_standard_code'); // کد استاندارد قدیم
            $table->string('new_standard_code'); // کد استاندارد جدید

            $table->integer('theory_hour')->default(0); // زمان نظری - ساعت
            $table->integer('theory_minute')->default(0); // زمان نظری - دقیقه

            $table->integer('practice_hour')->default(0); // زمان عملی - ساعت
            $table->integer('practice_minute')->default(0); // زمان عملی - دقیقه

            $table->integer('project_hour')->default(0); // زمان پروژه - ساعت
            $table->integer('project_minute')->default(0); // زمان پروژه - دقیقه

            $table->integer('internship_hour')->default(0); // زمان کارورزی - ساعت
            $table->integer('internship_minute')->default(0); // زمان کارورزی - دقیقه

            $table->integer('total_hour')->default(0); // جمع کل - ساعت
            $table->integer('total_minute')->default(0); // جمع کل - دقیقه

            $table->string('education_level')->nullable(); // حداقل تحصیلات ورودی
            $table->foreignId('kardanesh_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('jobtype_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('trainer_qualification')->nullable(); // صلاحیت حرفه‌ای مربیان

            $table->date('draft_date')->nullable(); // تاریخ تدوین
            $table->string('image_path')->nullable(); // تصویر
            $table->string('standard_file')->nullable(); // فایل استاندارد

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professions');
    }
};
