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
        Schema::create('project_colaborators', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('project_id')->nullable('false');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->UnsignedBigInteger('colaborator_id')->nullable('false');
            $table->foreign('colaborator_id')->references('id')->on('colaborators')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_colaborators', function (Blueprint $table) {
            //
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
            $table->dropForeign(['colaborator_id']);
            $table->dropColumn('colaborator_id');
        });
        Schema::dropIfExists('project_colaborators');
    }
};
