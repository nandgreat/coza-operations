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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('member_code')->nullable();
            $table->unsignedBigInteger('church_id')->nullable();
            $table->foreign('church_id')->references('id')->on('churches');
            $table->longText('image_url')->nullable();
            $table->double('percentage_attendance', 5, 2)->default(0.00);
            $table->tinyInteger('total_attendance')->default(0);
            $table->tinyInteger('total_services')->nullable();
            $table->tinyInteger('expected_attendance');
            $table->tinyInteger('is_onboarding_completed')->default(0)->comment('0 - Not completed, 1 - Completed');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
