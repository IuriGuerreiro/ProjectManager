@extends('layouts.app')

@section('title', 'Convidar para Equipa')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('teams.view', ['team_id' => $team->id]) }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Convidar Utilizador</h1>
            <p class="text-dark-muted text-sm mt-1">Adicione novos membros à equipa {{ $team->team_designation }}</p>
        </div>
    </div>

    <div class="max-w-2xl">
        <x-v5-card>
            <form action="{{ route('teams.storeUser', ['team_id' => $team->id]) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <x-v5-label for="inputUserId" value="Selecionar Utilizador para Convidar" />
                    <select id="inputUserId" name="inputUserId" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200" required>
                        <option value="">Escolha um utilizador...</option>
                        @forelse ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @empty
                            <option value="" disabled>Nenhum utilizador disponível</option>
                        @endforelse
                    </select>
                    <p class="mt-2 text-xs text-dark-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Apenas utilizadores que ainda não fazem parte da equipa aparecem nesta lista
                    </p>
                </div>

                <div class="flex gap-3 pt-4">
                    <a href="{{ route('teams.view', ['team_id' => $team->id]) }}" class="flex-1 text-center px-6 py-3 bg-dark-surface border border-dark-border rounded-lg text-dark-muted hover:text-white hover:border-primary-500 transition duration-200">
                        Cancelar
                    </a>
                    <x-v5-button type="submit" class="flex-1">
                        <i class="fas fa-paper-plane mr-2"></i> Enviar Convite
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>
    </div>
@endsection
