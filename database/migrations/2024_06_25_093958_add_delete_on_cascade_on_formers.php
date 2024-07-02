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
        schema::table('formers', function (Blueprint $table) {
            $table->dropForeign(['train_id']);
            $table->foreign('train_id')->references('id')->on('trainings')->OnDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::table('formers', function (Blueprint $table) {
            $table->dropForeign(['train_id']);
            $table->foreign('train_id')->references('id')->on('trainings');
        });
    }
};
