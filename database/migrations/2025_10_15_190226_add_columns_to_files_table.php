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
        Schema::table('files', function (Blueprint $table) {
            $table->boolean('status')->default(true)->after('id'); // فعال یا غیرفعال
            $table->string('url')->after('status'); // مسیر فایل
            $table->string('type')->nullable()->after('url'); // image, video, pdf, docx و...
            $table->morphs('fileable'); // fileable_id و fileable_type برای polymorphic
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropMorphs('fileable');
            $table->dropColumn(['type', 'url', 'status']);
        });
    }
};
