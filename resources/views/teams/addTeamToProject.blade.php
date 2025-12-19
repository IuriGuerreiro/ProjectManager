@extends('layouts.app')

@section('title', 'Atribuir Projetos')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('teams.view', ['team_id' => $team->id]) }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Atribuir Equipa a Projetos</h1>
    </div>

    <div class="max-w-2xl">
        <x-v5-card title="Equipa: {{ $team->team_designation }}">
            <form action="{{ route('teams.storeTeamToProject', ['user_id' => $team->id]) }}" method="POST" class="space-y-6">
                @csrf 
                <div>
                    <x-v5-label for="inputProjectId" value="Selecionar Projeto" />
                    <select id="inputProjectId" name="inputProjectId" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->project_designation }} ({{ $project->project_code }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end pt-4">
                    <x-v5-button type="submit">
                        <i class="fas fa-plus mr-2"></i> Confirmar Atribuição
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>
    </div>
@endsection
