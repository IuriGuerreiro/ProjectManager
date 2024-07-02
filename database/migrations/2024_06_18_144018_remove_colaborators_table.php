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
        Schema::table('colaborators', function (Blueprint $table) {
            $table->dropforeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('colaborators', function (Blueprint $table) {
            $table->UnsignedBigInteger('user_id')->nullable('false');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
