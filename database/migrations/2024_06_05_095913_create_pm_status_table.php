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
        Schema::create('pm_status', function (Blueprint $table) {
            $table->id();
            $table->string('status_designation',100)->nullable('false');
            $table->string('status_destination',100)->nullable('false');
            $table->string('status_stage',100)->nullable('false');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pm_status');
    }
};
