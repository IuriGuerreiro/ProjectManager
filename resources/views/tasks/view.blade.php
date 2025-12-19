@extends('layouts.app')

@section('title', 'Detalhes da Tarefa')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('tasks.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">{{ $task->task_designation }}</h1>
                <p class="text-dark-muted text-sm mt-1">Código: <span class="text-primary-400 font-mono">{{ $task->task_code }}</span></p>
            </div>
        </div>
        <div class="flex gap-3">
             <x-v5-button variant="secondary" onclick="window.location.href='{{ route('tasks.edit', ['id' => $task->id]) }}'">
                <i class="fas fa-edit mr-2"></i> Editar
            </x-v5-button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <x-v5-card title="Descrição">
                <div class="prose prose-invert max-w-none text-dark-muted leading-relaxed">
                    {{ $task->description ?? "Nenhuma descrição fornecida." }}
                </div>
            </x-v5-card>

            <x-v5-card title="Colaboradores Atribuídos">
                <x-slot name="action">
                    <x-v5-button size="sm" variant="secondary" onclick="window.location.href='{{ route('users.AddToTask', ['project_id' => $task->id]) }}'">
                        <i class="fas fa-user-plus mr-2"></i> Atribuir
                    </x-v5-button>
                </x-slot>

                <x-v5-table :headers="['Nome', 'Email', 'Ações']">
                    @forelse ($users as $user)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4 font-medium text-white">{{ $user->name ?? "--" }}</td>
                            <td class="px-6 py-4 text-dark-muted">{{ $user->email ?? "--" }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('users.removeFromTask', ['id' => $user->id]) }}" class="text-red-400 hover:text-red-300 transition">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                                Nenhuma colaborador atribuído a esta tarefa.
                            </td>
                        </tr>
                    @endforelse
                </x-v5-table>
            </x-v5-card>
        </div>

        <div class="space-y-8">
            <x-v5-card title="Informações Gerais">
                <div class="space-y-4">
                    <div>
                        <x-v5-label value="Projeto Associado" />
                        <a href="{{ route('projects.view', ['id' => $project->id]) }}" class="text-primary-400 hover:text-primary-300 transition font-medium">
                            {{ $project->project_designation }}
                        </a>
                    </div>
                    <div>
                        <x-v5-label value="Estado Atual" />
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dark-bg text-dark-muted border border-dark-border">
                            {{ $task->task_status }}
                        </span>
                    </div>
                </div>
            </x-v5-card>

            <x-v5-card title="Ações">
                <x-v5-button variant="danger" size="sm" class="w-full" onclick="return confirm('Tem a certeza que deseja apagar esta tarefa?')">
                    <i class="fas fa-trash mr-2"></i> Apagar Tarefa
                </x-v5-button>
            </x-v5-card>
        </div>
    </div>
@endsection
