<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $statuses = [
            [
                'status_designation' => 'Pendente',
                'status_destination' => 'geral',
                'status_stage' => 'inicial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_designation' => 'Em Curso',
                'status_destination' => 'geral',
                'status_stage' => 'inicial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_designation' => 'Concluído',
                'status_destination' => 'geral',
                'status_stage' => 'inicial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_designation' => 'Cancelado',
                'status_destination' => 'geral',
                'status_stage' => 'inicial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'status_designation' => 'Em Pausa',
                'status_destination' => 'geral',
                'status_stage' => 'inicial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pm_status')->insert($statuses);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('pm_status')->whereIn('status_designation', [
            'Pendente',
            'Em Curso',
            'Concluído',
            'Cancelado',
            'Em Pausa',
        ])->delete();
    }
};
