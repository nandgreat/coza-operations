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
        Schema::create('generator_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('generator_id');
            $table->foreign('generator_id')->references('id')->on('generators');
            $table->dateTime('time_on');
            $table->unsignedBigInteger('turn_on_worker_id');
            $table->foreign('turn_on_worker_id')->references('id')->on('workers');
            $table->dateTime('time_off');
            $table->unsignedBigInteger('turn_off_worker_id');
            $table->foreign('turn_off_worker_id')->references('id')->on('workers');
            $table->string('purpose_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generator_usage_logs');
    }
};
