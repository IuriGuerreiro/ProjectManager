@extends('layouts.app')

@section('title', 'Editar Equipa')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('teams.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Editar Equipa</h1>
    </div>

    <div class="space-y-8">
        <x-v5-card title="Informações da Equipa">
            <form action="{{ route('teams.update', ['team_id' => $team->id]) }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-v5-label for="inputTeamDesignation" value="Designação da Equipa" />
                        <x-v5-input id="inputTeamDesignation" name="inputTeamDesignation" value="{{ $team->team_designation }}" />
                    </div>
                    <div>
                        <x-v5-label for="inputTeamfunction" value="Função da Equipa" />
                        <x-v5-input id="inputTeamfunction" name="inputTeamfunction" value="{{ $team->team_function }}" />
                    </div>
                </div>
                <div class="flex justify-end">
                    <x-v5-button type="submit">
                        <i class="fas fa-sync-alt mr-2"></i> Atualizar
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <x-v5-card title="Gerir Membros">
                <x-slot name="action">
                    <x-v5-button size="sm" variant="secondary" onclick="window.location.href='{{ route('teams.AddUser', ['user_id' => $team->id]) }}'">
                        <i class="fas fa-plus mr-2"></i> Adicionar
                    </x-v5-button>
                </x-slot>
                
                <x-v5-table :headers="['Nome', 'Email', 'Ações']">
                    @foreach ($users as $user)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4 text-white">{{ $user->user_name ?? "--" }}</td>
                            <td class="px-6 py-4 text-dark-muted">{{ $user->user_email ?? "--" }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('teams.removerUser', ['user_id' => $user->id]) }}" class="text-red-400 hover:text-red-300 transition">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-v5-table>
            </x-v5-card>

            <x-v5-card title="Gerir Projetos">
                <x-slot name="action">
                    <x-v5-button size="sm" variant="secondary" onclick="window.location.href='{{ route('teams.addTeamToProject', ['team_id' => $team->id]) }}'">
                        <i class="fas fa-plus mr-2"></i> Adicionar
                    </x-v5-button>
                </x-slot>

                <x-v5-table :headers="['Projeto', 'Estado', 'Ações']">
                    @foreach ($projects as $project)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4 text-white">{{ $project->project_designation }}</td>
                            <td class="px-6 py-4 text-dark-muted">{{ $project->project_status }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('teams.removeProject', ['Teams_project_id' => $project->id]) }}" class="text-red-400 hover:text-red-300 transition">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-v5-table>
            </x-v5-card>
        </div>
    </div>
@endsection
