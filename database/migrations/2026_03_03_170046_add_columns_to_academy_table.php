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
        Schema::table('academies', function (Blueprint $table) {
            // مشخصات پروانه تاسیس ===================================================
            $table->unsignedBigInteger('id_number')->unique();
            $table->string('export_number');
            $table->date('export_start');
            $table->date('export_end');
            $table->enum('license',['first','extension']);
            $table->date('first_license_date')->nullable();
            $table->enum('gender',['male','female','both']);
            $table->boolean('tabsare_34');


            // اطلاعات موسس=============================================================
            // حقیقی
            $table->string('natural_name')->nullable();
            $table->string('natural_family')->nullable();
            $table->string('natural_father')->nullable();
            $table->date('natural_birth_date')->nullable();
            $table->string('national_code',11)->nullable();
            $table->string('national_id_number',11)->nullable();
            $table->string('natural_issue',20)->nullable();
            // حقوقی
            $table->string('legal_company_name')->nullable();
            $table->string('legal_register_number',20)->nullable();
            $table->date('register_date')->nullable();
            $table->string('legal_manager')->nullable();
            // فیلد های مشترک موسس
            $table->string('founder_phone',11);
            $table->string('founder_mobile',11);
            $table->string('founder_email')->nullable();
            $table->string('founder_address')->nullable();


            // اطلاعات تماس ==========================================================
            $table->foreignId('state_id')->constrained('cities','id')->cascadeOnDelete();
            $table->foreignId('city_id')->constrained('cities','id')->cascadeOnDelete();
            $table->string('postal_code',10);
            $table->string('fax',11)->nullable();
            $table->string('mobile',11)->nullable();
            $table->string('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academies', function (Blueprint $table) {
            //
        });
    }
};
