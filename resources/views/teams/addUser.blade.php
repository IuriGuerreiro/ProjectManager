@extends('layouts.app')

@section('title', 'Adicionar Membro')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('teams.view', ['team_id' => $team->id]) }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Adicionar Membro à Equipa</h1>
    </div>

    <div class="max-w-2xl">
        <x-v5-card title="Equipa: {{ $team->team_designation }}">
            <form action="{{ route('teams.storeUser', ['team_id' => $team->id]) }}" method="POST" class="space-y-6">
                @csrf 
                <div>
                    <x-v5-label for="inputUserId" value="Selecionar Utilizador" />
                    <select id="inputUserId" name="inputUserId" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end pt-4">
                    <x-v5-button type="submit">
                        <i class="fas fa-user-plus mr-2"></i> Confirmar Membro
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>
    </div>
@endsection
