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
        Schema::create('classification_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('testing_data_id');
            $table->foreignId('predicted_class_id');
            $table->decimal('probability', 10, 5);
            $table->timestamps();

            $table->foreign('testing_data_id')->on('testing_data')->references('id');
            $table->foreign('predicted_class_id')->on('class_labels')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classification_results');
    }
};
