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
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users', 'id')->cascadeOnDelete()->comment('ایجاد کننده آگهی');
            $table->foreignId('academy_id')->constrained()->cascadeOnDelete()->nullable()->commment('متقاضی آگهی');
            $table->foreignId('position_id')->constrained()->restrictOnDelete()->nullable()->commment('مجایگاه آگهی');

            $table->string('title');
            $table->text('description')->nullable();

            $table->string('image')->nullable();
            $table->string('video')->nullable();

            $table->unsignedInteger('duration')->default(5);

            $table->json('extra_data')->nullable()->commment('اطلاعات اضافی'); // تفاوت‌های خاص هر جایگاه

            $table->enum('status', [
                'pending_review',
                'rejected',
                'approved',
                'awaiting_payment',
                'active',
                'expired',
                'cancelled'
            ])->default('pending_review');

            $table->text('rejected_reason')->nullable();

            $table->timestamp('payment_expires_at')->nullable();

            $table->timestamps();

            $table->index(['academy_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisements');
    }
};
