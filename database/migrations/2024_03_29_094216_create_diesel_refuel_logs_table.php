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
            $table->text('refuel_receipt_image');
            $table->unsignedBigInteger('topup_worker');
            $table->foreign('topup_worker')->references('id')->on('workers');
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
