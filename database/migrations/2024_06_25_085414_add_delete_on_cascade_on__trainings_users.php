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
        schema::table('trainings_users', function (Blueprint $table) {
            $table->dropForeign(['train_id']);
            $table->dropForeign(['users_id']);
            $table->foreign('users_id')->references('id')->on('users')->OnDelete('cascade');
            $table->foreign('train_id')->references('id')->on('trainings')->OnDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::table('trainings_users', function (Blueprint $table) {
            $table->dropForeign(['train_id']);
            $table->dropForeign(['users_id']);
            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('train_id')->references('id')->on('trainings');
        });
    }
};
