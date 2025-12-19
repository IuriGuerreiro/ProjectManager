@extends('layouts.app')

@section('title', 'Convite Expirado')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-6">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-red-500/10 rounded-full mb-4">
                    <i class="fas fa-clock text-3xl text-red-400"></i>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Convite Expirado</h1>
                <p class="text-dark-muted text-sm">Este link de convite já não é válido</p>
            </div>

            <x-v5-card>
                <div class="text-center space-y-6">
                    <div>
                        <h2 class="text-xl font-semibold text-white mb-2">{{ $team->team_designation }}</h2>
                        @if($team->team_function)
                            <p class="text-dark-muted text-sm">{{ $team->team_function }}</p>
                        @endif
                    </div>

                    <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
                        <p class="text-sm text-red-400">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Este link de convite expirou e já não pode ser usado
                        </p>
                    </div>

                    <div class="space-y-3 pt-2">
                        <p class="text-sm text-dark-muted">
                            Para se juntar a esta equipa, por favor contacte um membro da equipa e peça um novo link de convite.
                        </p>

                        <x-v5-button onclick="window.location.href='{{ route('dashboard') }}'" class="w-full">
                            <i class="fas fa-arrow-left mr-2"></i> Voltar ao Dashboard
                        </x-v5-button>
                    </div>
                </div>
            </x-v5-card>
        </div>
    </div>
@endsection
