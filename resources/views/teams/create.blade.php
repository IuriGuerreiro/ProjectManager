@extends('layouts.app')

@section('title', 'Criar Equipa')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('teams.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Criar Nova Equipa</h1>
    </div>

    <div class="max-w-2xl">
        <x-v5-card>
            <form action="{{ route('teams.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <x-v5-label for="inputTeamDesignation" value="Designação da Equipa" />
                    <x-v5-input id="inputTeamDesignation" name="inputTeamDesignation" placeholder="Ex: Equipa de Desenvolvimento" required />
                </div>

                <div>
                    <x-v5-label for="inputTeamfunction" value="Função da Equipa" />
                    <x-v5-input id="inputTeamfunction" name="inputTeamfunction" placeholder="Ex: Desenvolvimento Backend e API" required />
                </div>

                <div class="flex justify-end pt-4">
                    <x-v5-button type="submit">
                        <i class="fas fa-save mr-2"></i> Criar Equipa
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>
    </div>
@endsection
