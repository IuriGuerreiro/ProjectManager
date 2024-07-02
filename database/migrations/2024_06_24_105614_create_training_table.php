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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('trainings_code', 8)->nullable('false');
            $table->string('trainings_designation', 255)->nullable('false');
            $table->unsignedBigInteger('status')->nullable('false');
            $table->foreign('status')->references('id')->on('pm_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training', function (Blueprint $table) {
            $table->dropForeign(['status']);
        });
        Schema::dropIfExists('training');
    }
};
