@extends('layouts.app')

@section('title', '404 - Página Não Encontrada')

@section('content')
    <div class="min-h-[60vh] flex items-center justify-center">
        <div class="text-center">
            <div class="mb-8">
                <div class="inline-block relative">
                    <h1 class="text-9xl font-bold text-primary-500/20">404</h1>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fas fa-exclamation-triangle text-6xl text-primary-500"></i>
                    </div>
                </div>
            </div>

            <h2 class="text-3xl font-bold text-white mb-4">Página Não Encontrada</h2>
            <p class="text-dark-muted text-lg mb-8 max-w-md mx-auto">
                Oops! A página que procura não existe ou foi movida.
            </p>

            <div class="flex gap-4 justify-center flex-wrap">
                <button onclick="window.history.back()" class="px-6 py-3 bg-dark-surface hover:bg-dark-border text-white rounded-lg transition duration-200 font-medium border border-dark-border">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar
                </button>
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition duration-200 font-medium">
                    <i class="fas fa-home mr-2"></i> Ir para Dashboard
                </a>
            </div>

            <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-2xl mx-auto">
                <a href="{{ route('projects.list') }}" class="p-4 bg-dark-surface hover:bg-dark-border rounded-lg transition duration-200 border border-dark-border group">
                    <i class="fas fa-layer-group text-2xl text-primary-400 mb-2 group-hover:scale-110 transition-transform"></i>
                    <p class="text-sm text-dark-muted group-hover:text-white transition">Projetos</p>
                </a>
                <a href="{{ route('tasks.list') }}" class="p-4 bg-dark-surface hover:bg-dark-border rounded-lg transition duration-200 border border-dark-border group">
                    <i class="fas fa-check-square text-2xl text-yellow-400 mb-2 group-hover:scale-110 transition-transform"></i>
                    <p class="text-sm text-dark-muted group-hover:text-white transition">Tarefas</p>
                </a>
                <a href="{{ route('teams.list') }}" class="p-4 bg-dark-surface hover:bg-dark-border rounded-lg transition duration-200 border border-dark-border group">
                    <i class="fas fa-user-group text-2xl text-purple-400 mb-2 group-hover:scale-110 transition-transform"></i>
                    <p class="text-sm text-dark-muted group-hover:text-white transition">Equipas</p>
                </a>
                <a href="{{ route('trainings.list') }}" class="p-4 bg-dark-surface hover:bg-dark-border rounded-lg transition duration-200 border border-dark-border group">
                    <i class="fas fa-graduation-cap text-2xl text-green-400 mb-2 group-hover:scale-110 transition-transform"></i>
                    <p class="text-sm text-dark-muted group-hover:text-white transition">Formações</p>
                </a>
            </div>
        </div>
    </div>
@endsection
