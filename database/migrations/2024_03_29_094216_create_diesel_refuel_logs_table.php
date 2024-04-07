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
        Schema::create('diesel_refuel_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('diesel_level_before');
            $table->integer('diesel_quantity');
            $table->integer('diesel_level_after');
            $table->text('invoice_image_url');
            $table->text('waybill_image_url');
            $table->text('diesel_before_image_url');
            $table->text('diesel_after_image_url');
            $table->unsignedBigInteger('topup_worker_id');
            $table->foreign('topup_worker_id')->references('id')->on('users');
            $table->unsignedBigInteger('confirmation_worker_id');
            $table->foreign('confirmation_worker_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diesel_refuel_logs');
    }
};
