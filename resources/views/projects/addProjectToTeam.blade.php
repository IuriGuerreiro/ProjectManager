@extends('layouts.app')

@section('title', 'Gerir Equipas do Projeto')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('projects.edit', ['id' => $project->id]) }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Gerir Equipas</h1>
            <p class="text-dark-muted text-sm mt-1">Projeto: <span class="text-primary-400">{{ $project->project_designation }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Add Teams Form -->
        <x-v5-card title="Adicionar Novas Equipas">
            <form action="{{ route('teams.storeProjectToTeam', ['project_id' => $project->id]) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <x-v5-label value="Selecione as equipas para adicionar" />
                    <div class="grid grid-cols-1 gap-3 p-4 bg-dark-bg rounded-xl border border-dark-border max-h-80 overflow-y-auto">
                        @forelse($teams as $team)
                            <label class="flex items-center space-x-3 p-3 rounded-lg border border-dark-border hover:bg-dark-surface transition cursor-pointer group">
                                <input type="checkbox" name="inputProjectTeams[]" value="{{ $team->id }}" class="rounded bg-dark-bg border-dark-border text-primary-600 focus:ring-primary-500 focus:ring-offset-dark-surface transition">
                                <span class="text-sm text-white group-hover:text-primary-400 transition">{{ $team->team_designation }}</span>
                            </label>
                        @empty
                            <p class="text-sm text-dark-muted text-center py-4">Todas as equipas disponíveis já estão associadas.</p>
                        @endforelse
                    </div>
                </div>

                @if($teams->count() > 0)
                    <div class="flex justify-end pt-4">
                        <x-v5-button type="submit">
                            <i class="fas fa-plus mr-2"></i> Adicionar Selecionadas
                        </x-v5-button>
                    </div>
                @endif
            </form>
        </x-v5-card>

        <!-- Existing Teams List -->
        <x-v5-card title="Equipas Associadas">
            <x-v5-table :headers="['Equipa', 'Ações']">
                @forelse($existingTeams as $team)
                    <tr class="hover:bg-dark-border/30 transition duration-200">
                        <td class="px-6 py-4 font-medium text-white">{{ $team->team_designation }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('teams.removeProject', ['Teams_project_id' => $team->pivot_id]) }}" 
                               onclick="return confirm('Tem a certeza que deseja remover esta equipa do projeto?')"
                               class="text-red-400 hover:text-red-300 transition"
                               title="Remover Equipa">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                            Nenhuma equipa associada a este projeto.
                        </td>
                    </tr>
                @endforelse
            </x-v5-table>
        </x-v5-card>
    </div>
@endsection
