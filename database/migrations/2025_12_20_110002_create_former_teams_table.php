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
        Schema::create('former_teams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('former_id');
            $table->unsignedBigInteger('team_id');
            $table->foreign('former_id')->references('id')->on('formers')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['former_id', 'team_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('former_teams');
    }
};
