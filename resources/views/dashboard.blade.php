@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-white">Bem-vindo de volta, {{ Auth::user()->name }}!</h1>
        <p class="text-dark-muted mt-1">Aqui está o que está a acontecer nos seus projetos hoje.</p>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-v5-card class="hover:border-primary-500/30 transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-dark-muted text-sm font-medium uppercase tracking-wider">Projetos Ativos</h3>
                <div class="w-8 h-8 rounded-lg bg-primary-500/10 flex items-center justify-center text-primary-400">
                    <i class="fas fa-layer-group"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">12</p>
            <p class="text-xs text-green-400 mt-2"><i class="fas fa-arrow-up"></i> +2 este mês</p>
        </x-v5-card>

        <x-v5-card class="hover:border-primary-500/30 transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-dark-muted text-sm font-medium uppercase tracking-wider">Tarefas Pendentes</h3>
                <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center text-yellow-400">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">48</p>
            <p class="text-xs text-red-400 mt-2">15 atrasadas</p>
        </x-v5-card>

        <x-v5-card class="hover:border-primary-500/30 transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-dark-muted text-sm font-medium uppercase tracking-wider">Equipa</h3>
                <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-400">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">24</p>
            <p class="text-xs text-dark-muted mt-2">6 online agora</p>
        </x-v5-card>

        <x-v5-card class="hover:border-primary-500/30 transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-dark-muted text-sm font-medium uppercase tracking-wider">Formações</h3>
                <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center text-green-400">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">5</p>
            <p class="text-xs text-primary-400 mt-2">Próxima: Amanhã</p>
        </x-v5-card>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <x-v5-card title="Projetos Recentes">
                <x-slot name="action">
                    <a href="{{ route('projects.list') }}" class="text-primary-400 text-sm font-medium hover:text-primary-300 transition">Ver todos</a>
                </x-slot>
                
                <x-v5-table :headers="['Projeto', 'Estado', 'Progresso', 'Ações']">
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded bg-primary-500/10 text-primary-400 flex items-center justify-center font-bold text-xs mr-3">WR</div>
                                <span class="font-medium text-white">Website Redesign</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">Em Curso</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-full bg-dark-bg h-1.5 rounded-full">
                                <div class="bg-primary-500 h-1.5 rounded-full" style="width: 65%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-dark-muted hover:text-white transition"><i class="fas fa-ellipsis-v"></i></button>
                        </td>
                    </tr>
                    <!-- Add more dummy rows if needed -->
                </x-v5-table>
            </x-v5-card>
        </div>

        <div>
            <x-v5-card title="Tarefas Prioritárias">
                <ul class="space-y-4">
                    <li class="flex items-start gap-3 p-3 rounded-xl bg-dark-bg/50 border border-dark-border/50 hover:border-primary-500/30 transition duration-200">
                        <div class="mt-1 w-2 h-2 rounded-full bg-red-500 shadow-lg shadow-red-900/50"></div>
                        <div>
                            <p class="text-sm font-medium text-white">Revisão de Código API</p>
                            <p class="text-xs text-dark-muted">Projeto: Mobile App</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3 p-3 rounded-xl bg-dark-bg/50 border border-dark-border/50 hover:border-primary-500/30 transition duration-200">
                        <div class="mt-1 w-2 h-2 rounded-full bg-yellow-500 shadow-lg shadow-yellow-900/50"></div>
                        <div>
                            <p class="text-sm font-medium text-white">Update Documentation</p>
                            <p class="text-xs text-dark-muted">Projeto: Website Redesign</p>
                        </div>
                    </li>
                </ul>
            </x-v5-card>
        </div>
    </div>
@endsection