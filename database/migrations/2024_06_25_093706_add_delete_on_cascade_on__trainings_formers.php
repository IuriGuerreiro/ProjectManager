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
        schema::table('training_formers', function (Blueprint $table) {
            $table->dropForeign(['train_id']);
            $table->dropForeign(['former_id']);
            $table->foreign('former_id')->references('id')->on('formers')->OnDelete('cascade');
            $table->foreign('train_id')->references('id')->on('trainings')->OnDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::table('training_formers', function (Blueprint $table) {
            $table->dropForeign(['train_id']);
            $table->dropForeign(['users_id']);
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('train_id')->references('id')->on('trainings');
        });
    }
};
