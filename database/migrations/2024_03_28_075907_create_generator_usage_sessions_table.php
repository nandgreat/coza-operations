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
        Schema::create('generator_usage_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('diesel_level_before');
            $table->dateTime('time_start');
            $table->tinyInteger('session_status')->comment('1 - Running, 2 - Ended')->default(1);
            $table->dateTime('time_stop')->nullable();
            $table->integer('diesel_level_after')->nullable();
            $table->unsignedBigInteger('turn_on_worker_id');
            $table->foreign('turn_on_worker_id')->references('id')->on('users');
            $table->unsignedBigInteger('turn_off_worker_id')->nullable();
            $table->foreign('turn_off_worker_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generator_usage_sessions');
    }
};
