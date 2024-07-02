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
        Schema::create('trainings_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('train_id')->nullable('false');
            $table->foreign('train_id')->references('id')->on('trainings');
            $table->unsignedBigInteger('users_id')->nullable('false');
            $table->foreign('users_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trainings_teams', function (Blueprint $table) {
            $table->dropForeign(['Train_id']);
            $table->dropForeign(['teams_id']);
        });
        Schema::dropIfExists('trainigs_teams');
    }
};
