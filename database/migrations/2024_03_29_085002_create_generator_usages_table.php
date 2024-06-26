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
        Schema::create('generator_usages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('generator_id');
            $table->foreign('generator_id')->references('id')->on('generators');
            $table->dateTime('time_on');
            $table->unsignedBigInteger('usage_session_id');
            $table->foreign('usage_session_id')->references('id')->on('generator_usage_sessions');
            $table->unsignedBigInteger('turn_on_worker_id');
            $table->foreign('turn_on_worker_id')->references('id')->on('users');
            $table->dateTime('time_off')->nullable();
            $table->unsignedBigInteger('generator_purpose_id');
            $table->foreign('generator_purpose_id')->references('id')->on('generator_purposes');
            $table->unsignedBigInteger('turn_off_worker_id')->nullable();
            $table->foreign('turn_off_worker_id')->references('id')->on('users');
            $table->string('generator_load')->nullable();
            $table->unsignedBigInteger('approved_by');
            $table->foreign('approved_by')->references('id')->on('approval_admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generator_usages');
    }
};
