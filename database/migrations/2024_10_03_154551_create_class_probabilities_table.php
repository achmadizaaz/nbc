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
        Schema::create('class_probabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_label_id');
            $table->bigInteger('total_data');
            $table->decimal('prior_probability', 10,5);
            $table->timestamps();

            $table->foreign('class_label_id')->on('class_labels')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_probabilities');
    }
};
