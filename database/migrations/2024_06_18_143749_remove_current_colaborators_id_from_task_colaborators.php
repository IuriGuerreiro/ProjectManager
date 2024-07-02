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
        Schema::table('task_colaborators', function (Blueprint $table) {
            $table->dropforeign(['colaborator_id']);
            $table->dropColumn('colaborator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_colaborators', function (Blueprint $table) {
            $table->UnsignedBigInteger('colaborator_id')->nullable('false');
            $table->foreign('colaborator_id')->references('id')->on('colaborators')->onDelete('cascade');
        });
    }
};
