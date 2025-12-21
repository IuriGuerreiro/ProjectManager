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
        Schema::create('task_trainings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('training_id');
            $table->string('required_for_status')->nullable();
            $table->foreign('task_id')
                  ->references('id')
                  ->on('tasks')
                  ->onDelete('cascade');
            $table->foreign('training_id')
                  ->references('id')
                  ->on('trainings')
                  ->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            // Prevent duplicate training requirements
            $table->unique(['task_id', 'training_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_trainings');
    }
};
