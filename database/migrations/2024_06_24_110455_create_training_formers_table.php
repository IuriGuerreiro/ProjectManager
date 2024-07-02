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
        Schema::create('training_formers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('train_id')->nullable('false');
            $table->foreign('train_id')->references('id')->on('trainings');
            $table->unsignedBigInteger('former_id')->nullable('false');
            $table->foreign('former_id')->references('id')->on('formers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_formers', function (Blueprint $table) {
            $table->dropForeign(['Train_id']);
            $table->dropForeign(['former_id']);
        });
        Schema::dropIfExists('training_formers');
    }
};
