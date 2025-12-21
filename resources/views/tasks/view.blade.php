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

            <x-v5-card title="Subtarefas">
                <x-slot name="action">
                    <x-v5-button size="sm" variant="secondary" onclick="window.location.href='{{ route('tasks.create') }}?parent_id={{ $task->id }}'">
                        <i class="fas fa-plus mr-2"></i> Adicionar Subtarefa
                    </x-v5-button>
                </x-slot>

                @if($subtasks->count() > 0)
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-dark-muted">Progresso Global</span>
                            <span class="text-sm font-medium text-primary-400">{{ number_format($task->completion_percentage, 0) }}%</span>
                        </div>
                        <div class="w-full bg-dark-border rounded-full h-2">
                            <div class="bg-primary-500 h-2 rounded-full transition-all" style="width: {{ $task->completion_percentage }}%"></div>
                        </div>
                    </div>
                @endif

                <x-v5-table :headers="['Tarefa', 'Estado', 'Progresso', 'Ações']">
                    @forelse ($subtasks as $subtask)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4">
                                <a href="{{ route('tasks.view', ['id' => $subtask->id]) }}" class="font-medium text-primary-400 hover:text-primary-300">
                                    {{ $subtask->task_designation }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dark-bg text-dark-muted border border-dark-border">
                                    {{ $subtask->task_status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-dark-muted">{{ number_format($subtask->completion_percentage, 0) }}%</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('tasks.edit', ['id' => $subtask->id]) }}" class="text-primary-400 hover:text-primary-300 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('tasks.delete', ['id' => $subtask->id]) }}" class="text-red-400 hover:text-red-300" onclick="return confirm('Apagar esta subtarefa?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                                Nenhuma subtarefa criada.
                            </td>
                        </tr>
                    @endforelse
                </x-v5-table>
            </x-v5-card>

            <x-v5-card title="Dependências">
                <x-slot name="action">
                    <x-v5-button size="sm" variant="secondary" onclick="window.location.href='{{ route('tasks.addDependency', ['task_id' => $task->id]) }}'">
                        <i class="fas fa-link mr-2"></i> Adicionar Dependência
                    </x-v5-button>
                </x-slot>

                @if(!$dependenciesComplete)
                    <div class="mb-4 p-3 bg-yellow-500/10 border border-yellow-500/30 rounded-lg">
                        <p class="text-sm text-yellow-400">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Esta tarefa depende de outras tarefas que ainda não estão concluídas.
                        </p>
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-dark-muted mb-2">Esta tarefa depende de:</h4>
                        <x-v5-table :headers="['Tarefa', 'Estado', 'Ações']">
                            @forelse ($dependencies as $dependency)
                                <tr class="hover:bg-dark-border/30 transition duration-200">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('tasks.view', ['id' => $dependency->id]) }}" class="font-medium text-primary-400 hover:text-primary-300">
                                            {{ $dependency->task_designation }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $dependency->task_status === 'concluído' ? 'bg-green-500/20 text-green-400 border-green-500/30' : 'bg-dark-bg text-dark-muted border-dark-border' }} border">
                                            {{ $dependency->task_status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('tasks.removeDependency', ['id' => $dependency->pivot->id]) }}" class="text-red-400 hover:text-red-300" onclick="return confirm('Remover dependência?')">
                                            <i class="fas fa-unlink"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-dark-muted opacity-50 italic">
                                        Esta tarefa não depende de outras tarefas.
                                    </td>
                                </tr>
                            @endforelse
                        </x-v5-table>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-dark-muted mb-2">Tarefas que dependem desta:</h4>
                        <x-v5-table :headers="['Tarefa', 'Estado']">
                            @forelse ($dependents as $dependent)
                                <tr class="hover:bg-dark-border/30 transition duration-200">
                                    <td class="px-6 py-4">
                                        <a href="{{ route('tasks.view', ['id' => $dependent->id]) }}" class="font-medium text-primary-400 hover:text-primary-300">
                                            {{ $dependent->task_designation }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dark-bg text-dark-muted border border-dark-border">
                                            {{ $dependent->task_status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-center text-dark-muted opacity-50 italic">
                                        Nenhuma tarefa depende desta.
                                    </td>
                                </tr>
                            @endforelse
                        </x-v5-table>
                    </div>
                </div>
            </x-v5-card>

            <x-v5-card title="Formações Obrigatórias">
                <x-slot name="action">
                    <x-v5-button size="sm" variant="secondary" onclick="window.location.href='{{ route('tasks.addTraining', ['task_id' => $task->id]) }}'">
                        <i class="fas fa-graduation-cap mr-2"></i> Adicionar Formação
                    </x-v5-button>
                </x-slot>

                @if(!$trainingsComplete)
                    <div class="mb-4 p-3 bg-red-500/10 border border-red-500/30 rounded-lg">
                        <p class="text-sm text-red-400">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            Os utilizadores atribuídos não completaram todas as formações obrigatórias.
                        </p>
                    </div>
                @endif

                <x-v5-table :headers="['Formação', 'Obrigatória Para', 'Ações']">
                    @forelse ($requiredTrainings as $training)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4">
                                <a href="{{ route('trainings.view', ['training_id' => $training->id]) }}" class="font-medium text-primary-400 hover:text-primary-300">
                                    {{ $training->trainings_designation }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-dark-muted">
                                {{ $training->pivot->required_for_status ?? 'Todos os estados' }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('tasks.removeTraining', ['id' => $training->pivot->id]) }}" class="text-red-400 hover:text-red-300" onclick="return confirm('Remover formação obrigatória?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                                Nenhuma formação obrigatória configurada.
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
                    @if($task->parent)
                        <div>
                            <x-v5-label value="Tarefa Pai" />
                            <a href="{{ route('tasks.view', ['id' => $task->parent->id]) }}" class="text-primary-400 hover:text-primary-300 transition font-medium">
                                {{ $task->parent->task_designation }}
                            </a>
                        </div>
                    @endif
                    <div>
                        <x-v5-label value="Estado Atual" />
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dark-bg text-dark-muted border border-dark-border">
                            {{ $task->task_status }}
                        </span>
                    </div>
                    <div>
                        <x-v5-label value="Progresso" />
                        <div class="flex items-center gap-2 mt-1">
                            <div class="flex-1 bg-dark-border rounded-full h-2">
                                <div class="bg-primary-500 h-2 rounded-full transition-all" style="width: {{ $task->completion_percentage }}%"></div>
                            </div>
                            <span class="text-sm font-medium text-primary-400">{{ number_format($task->completion_percentage, 0) }}%</span>
                        </div>
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
