@extends('layouts.app')

@section('title', 'Gestão de Equipas')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Equipas</h1>
            <p class="text-dark-muted text-sm mt-1">Gerencie as equipas e suas responsabilidades.</p>
        </div>
        <x-v5-button onclick="window.location.href='{{ route('teams.create') }}'">
            <i class="fas fa-users mr-2"></i> Criar Equipa
        </x-v5-button>
    </div>

    <x-v5-card>
        <x-v5-table :headers="['Designação', 'Função', 'Membros', 'Ações']">
            @foreach ($teams as $team)
                <tr class="hover:bg-dark-border/30 transition duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded bg-primary-500/10 text-primary-400 flex items-center justify-center font-bold text-xs mr-3">
                                {{ strtoupper(substr($team->team_designation, 0, 2)) }}
                            </div>
                            <div class="font-medium text-white">{{ $team->team_designation ?? "--" }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-dark-muted text-sm">{{ $team->team_function ?? "--" }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs bg-dark-bg px-2 py-1 rounded border border-dark-border text-dark-muted">N/A</span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('teams.view', ['team_id' => $team->id]) }}" class="text-dark-muted hover:text-primary-400 transition">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('teams.edit', ['team_id' => $team->id]) }}" class="text-dark-muted hover:text-yellow-400 transition">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('teams.delete', ['team_id' => $team->id]) }}" onclick="return confirm('Tem a certeza?')" class="text-dark-muted hover:text-red-400 transition">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-v5-table>
    </x-v5-card>
@endsection
