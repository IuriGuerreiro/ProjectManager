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
        Schema::create('task_colaborators', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('task_id')->nullable('false');
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
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
        Schema::table('task_colaborators', function (Blueprint $table) {
            //
            $table->dropForeign(['task_id']);
            $table->dropColumn('task_id');
            $table->dropForeign(['colaborator_id']);
            $table->dropColumn('colaborator_id');
        });
        Schema::dropIfExists('task_colaborators');
    }
};
