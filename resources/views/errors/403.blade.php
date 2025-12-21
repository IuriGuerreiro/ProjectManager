@extends('layouts.app')

@section('title', '403 - Acesso Negado')

@section('content')
    <div class="min-h-[60vh] flex items-center justify-center">
        <div class="text-center">
            <div class="mb-8">
                <div class="inline-block relative">
                    <h1 class="text-9xl font-bold text-red-500/20">403</h1>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-ban text-6xl text-red-500"></i>
                    </div>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-white mb-4">Acesso Negado</h2>
            <p class="text-dark-muted text-lg mb-8 max-w-md mx-auto">
                Não tem permissão para aceder a esta página.
            </p>

            <div class="flex gap-4 justify-center flex-wrap">
                <button onclick="window.history.back()" class="px-6 py-3 bg-dark-surface hover:bg-dark-border text-white rounded-lg transition duration-200 font-medium border border-dark-border">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar
                </button>
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition duration-200 font-medium">
                    <i class="fas fa-home mr-2"></i> Ir para Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection
