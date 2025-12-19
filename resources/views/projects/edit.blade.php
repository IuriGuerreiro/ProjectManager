@extends('layouts.app')

@section('title', 'Editar Projeto')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('projects.view', ['id' => $project->id]) }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Editar Projeto</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <x-v5-card title="Informações Gerais">
                <form action="{{ route('projects.update', ['id' => $project->id]) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-v5-label for="inputProjectDesignation" value="Designação do Projeto" />
                            <x-v5-input id="inputProjectDesignation" name="inputProjectDesignation" value="{{ $project->project_designation }}" />
                        </div>
                        <div>
                            <x-v5-label for="inputProjectAcronimo" value="Acrónimo (Não editável)" />
                            <x-v5-input id="inputProjectAcronimo" name="inputProjectAcronimo" value="{{ $project->project_code }}" disabled />
                        </div>
                    </div>

                    <div>
                        <x-v5-label for="inputProjectStatus" value="Estado do Projeto" />
                        <select id="inputProjectStatus" name="inputProjectStatus" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                            <option value="{{ $project->project_status }}" selected>{{ $project->project_status }} (Atual)</option>
                            @foreach($PmStatus as $status)
                                @if($status->status_designation != $project->project_status)
                                    <option value="{{$status->status_designation}}">{{$status->status_designation}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-v5-label for="inputProjectDescription" value="Descrição" />
                        <textarea id="inputProjectDescription" name="inputProjectDescription" rows="6" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white placeholder-dark-muted focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">{{ $project->description }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <x-v5-button type="submit">
                            <i class="fas fa-sync-alt mr-2"></i> Atualizar Projeto
                        </x-v5-button>
                    </div>
                </form>
            </x-v5-card>
        </div>

        <div class="space-y-8">
            <x-v5-card title="Gestão de Recursos">
                <div class="flex flex-col gap-2">
                    <x-v5-button variant="secondary" size="sm" class="justify-start" onclick="window.location.href='{{ route('teams.AddProjectToTeam', ['project_id' => $project->id]) }}'">
                        <i class="fas fa-users-cog mr-2 text-primary-400"></i> Gerir Equipas
                    </x-v5-button>
                    <x-v5-button variant="secondary" size="sm" class="justify-start">
                        <i class="fas fa-tasks mr-2 text-primary-400"></i> Ver Tarefas
                    </x-v5-button>
                </div>
            </x-v5-card>

            <x-v5-card title="Zona de Perigo">
                <p class="text-xs text-dark-muted mb-4">A eliminação de um projeto é irreversível. Todas as tarefas associadas serão mantidas mas o projeto será marcado como removido.</p>
                <x-v5-button variant="danger" size="sm" class="w-full" onclick="return confirm('Tem a certeza que deseja apagar este projeto?')">
                    <i class="fas fa-trash mr-2"></i> Apagar Projeto
                </x-v5-button>
            </x-v5-card>
        </div>
    </div>
@endsection
