@extends('layouts.app')

@section('title', '500 - Erro do Servidor')

@section('content')
    <div class="min-h-[60vh] flex items-center justify-center">
        <div class="text-center">
            <div class="mb-8">
                <div class="inline-block relative">
                    <h1 class="text-9xl font-bold text-yellow-500/20">500</h1>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-server text-6xl text-yellow-500"></i>
                    </div>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-white mb-4">Erro do Servidor</h2>
            <p class="text-dark-muted text-lg mb-8 max-w-md mx-auto">
                Algo correu mal no servidor. Por favor, tente novamente mais tarde.
            </p>

            <div class="flex gap-4 justify-center flex-wrap">
                <button onclick="window.location.reload()" class="px-6 py-3 bg-dark-surface hover:bg-dark-border text-white rounded-lg transition duration-200 font-medium border border-dark-border">
                    <i class="fas fa-sync-alt mr-2"></i> Tentar Novamente
                </button>
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition duration-200 font-medium">
                    <i class="fas fa-home mr-2"></i> Ir para Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection
