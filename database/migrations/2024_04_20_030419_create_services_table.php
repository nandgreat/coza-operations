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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_type_id')->default(1)->nullable();
            $table->foreign('service_type_id')->references('id')->on('service_types');
            $table->date('date');
            $table->time('time');
            $table->unsignedBigInteger('service_status_id')->default(1)->nullable();
            $table->foreign('service_status_id')->references('id')->on('service_statuses');
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
        Schema::dropIfExists('services');
    }
};
