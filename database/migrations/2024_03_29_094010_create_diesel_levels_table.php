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
        Schema::create('diesel_levels', function (Blueprint $table) {
            $table->id();
            $table->integer("diesel_level");
            $table->unsignedBigInteger('updated_by');
            $table->foreign('updated_by')->references('id')->on('workers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diesel_levels');
    }
};
