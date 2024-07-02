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
        Schema::create('teams_projects', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('project_id')->nullable('false');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->UnsignedBigInteger('team_id')->nullable('false');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_roles', function (Blueprint $table) {
            //
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });
        Schema::dropIfExists('teams_projects');
    }
};
