@extends('layouts.app')

@section('title', 'Detalhes da Equipa')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('teams.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">{{ $team->team_designation }}</h1>
                <p class="text-dark-muted text-sm mt-1">{{ $team->team_function }}</p>
            </div>
        </div>
        <div class="flex gap-3">
             <x-v5-button variant="secondary" onclick="window.location.href='{{ route('teams.edit', ['team_id' => $team->id]) }}'">
                <i class="fas fa-edit mr-2"></i> Editar
            </x-v5-button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Left Column: Users -->
        <x-v5-card title="Membros da Equipa">
            <x-slot name="action">
                <x-v5-button size="sm" variant="secondary" onclick="window.location.href='{{ route('teams.AddUser', ['user_id' => $team->id]) }}'">
                    <i class="fas fa-user-plus mr-2"></i> Adicionar
                </x-v5-button>
            </x-slot>

            <x-v5-table :headers="['Nome', 'Email']">
                @forelse ($users as $user)
                    <tr class="hover:bg-dark-border/30 transition duration-200">
                        <td class="px-6 py-4 font-medium text-white">{{ $user->user_name ?? "--" }}</td>
                        <td class="px-6 py-4 text-dark-muted">{{ $user->user_email ?? "--" }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                            Nenhum membro nesta equipa.
                        </td>
                    </tr>
                @endforelse
            </x-v5-table>
        </x-v5-card>

        <!-- Right Column: Projects -->
        <x-v5-card title="Projetos Atribuídos">
            <x-slot name="action">
                <x-v5-button size="sm" variant="secondary" onclick="window.location.href='{{ route('teams.addTeamToProject', ['team_id' => $team->id]) }}'">
                    <i class="fas fa-folder-plus mr-2"></i> Atribuir
                </x-v5-button>
            </x-slot>

            <x-v5-table :headers="['Projeto', 'Estado']">
                @forelse ($projects as $project)
                    <tr class="hover:bg-dark-border/30 transition duration-200">
                        <td class="px-6 py-4">
                            <div class="font-medium text-white">{{ $project->project_designation }}</div>
                            <div class="text-xs text-dark-muted mt-0.5">{{ \Str::limit($project->project_description, 30) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dark-bg text-dark-muted border border-dark-border">
                                {{ $project->project_status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                            Nenhum projeto atribuído.
                        </td>
                    </tr>
                @endforelse
            </x-v5-table>
        </x-v5-card>
    </div>
@endsection
