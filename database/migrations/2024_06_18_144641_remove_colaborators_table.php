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
        Schema::dropIfExists('colaborators');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('colaborators', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
};
