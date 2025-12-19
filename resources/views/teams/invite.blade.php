@extends('layouts.app')

@section('title', 'Convite para Equipa')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-6">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-500/10 rounded-full mb-4">
                    <i class="fas fa-users text-3xl text-primary-400"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Convite para Equipa</h1>
                <p class="text-dark-muted text-sm">Foi convidado para juntar-se a uma equipa</p>
            </div>

            <x-v5-card>
                <div class="text-center space-y-6">
                    <div>
                        <h2 class="text-xl font-semibold text-white mb-2">{{ $team->team_designation }}</h2>
                        @if($team->team_function)
                            <p class="text-dark-muted text-sm">{{ $team->team_function }}</p>
                        @endif
                    </div>

                    <div class="p-3 bg-dark-bg border border-dark-border rounded-lg">
                        <p class="text-xs text-dark-muted">
                            <i class="fas fa-clock mr-1"></i>
                            Este convite expira {{ $team->invite_expires_at->diffForHumans() }}
                        </p>
                        <p class="text-xs text-dark-muted mt-1">
                            {{ $team->invite_expires_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    @if($isMember)
                        <div class="p-4 bg-blue-500/10 border border-blue-500/20 rounded-lg">
                            <p class="text-sm text-blue-400">
                                <i class="fas fa-info-circle mr-2"></i>
                                Já é membro desta equipa
                            </p>
                        </div>

                        <div class="pt-4">
                            <x-v5-button onclick="window.location.href='{{ route('teams.view', ['team_id' => $team->id]) }}'" class="w-full">
                                <i class="fas fa-arrow-right mr-2"></i> Ver Equipa
                            </x-v5-button>
                        </div>
                    @else
                        <div class="p-4 bg-primary-500/10 border border-primary-500/20 rounded-lg">
                            <p class="text-sm text-primary-400">
                                <i class="fas fa-user-plus mr-2"></i>
                                Ao aceitar, será adicionado como membro desta equipa
                            </p>
                        </div>

                        <form action="{{ route('teams.joinViaInvite', ['token' => $team->invite_token]) }}" method="POST" class="space-y-4">
                            @csrf
                            <x-v5-button type="submit" class="w-full">
                                <i class="fas fa-check mr-2"></i> Aceitar Convite
                            </x-v5-button>

                            <a href="{{ route('dashboard') }}" class="block text-center text-dark-muted hover:text-white transition text-sm">
                                Voltar ao Dashboard
                            </a>
                        </form>
                    @endif
                </div>
            </x-v5-card>
        </div>
    </div>
@endsection
