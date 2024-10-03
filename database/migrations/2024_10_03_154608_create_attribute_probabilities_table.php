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
        Schema::create('attribute_probabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_label_id');
            $table->foreignId('attribute_id');
            $table->string('attribute_value');
            $table->decimal('conditional_probability', 10,5);
            $table->timestamps();
            $table->foreign('class_label_id')->on('class_labels')->references('id')->onDelete('cascade');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attribute_probabilities');
    }
};
