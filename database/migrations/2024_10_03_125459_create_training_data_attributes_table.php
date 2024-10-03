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
        Schema::create('training_data_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_data_id');
            $table->foreignId('attribute_id');
            $table->string('attribute_value');
            $table->timestamps();
            $table->foreign('training_data_id')->references('id')->on('training_data')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_data_attributes');
    }
};
