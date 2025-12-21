@extends('layouts.app')

@section('title', 'Editar Tarefa')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('tasks.view', ['id' => $task->id]) }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Editar Tarefa</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            {{-- Edit Form --}}
            <x-v5-card title="Informações da Tarefa">
                <form action="{{ route('tasks.update', ['id' => $task->id]) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-v5-label for="inputTaskDesignation" value="Designação" />
                            <x-v5-input id="inputTaskDesignation" name="inputTaskDesignation" value="{{ old('inputTaskDesignation', $task->task_designation) }}" />
                        </div>
                        <div>
                            <x-v5-label for="inputTaskCode" value="Código (Não editável)" />
                            <x-v5-input id="inputTaskCode" name="inputTaskCode" value="{{ $task->task_code ?? $task->task_designation }}" disabled />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-v5-label for="inputTaskStatus" value="Estado" />
                            <select id="inputTaskStatus" name="inputTaskStatus" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                                <option value="{{ $task->task_status }}" selected>{{ $task->task_status }} (Atual)</option>
                                @foreach($PmStatus as $status)
                                    @if($status->status_designation != $task->task_status)
                                        <option value="{{$status->status_designation}}">{{$status->status_designation}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-v5-label for="inputTaskProjectId" value="Projeto" />
                            <select id="inputTaskProjectId" name="inputTaskProjectId" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                                <option value="{{ $task->project_id }}">Manter atual</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ $project->id == $task->project_id ? 'selected' : '' }}>
                                        {{ $project->project_designation }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <x-v5-label for="inputParentTaskId" value="Tarefa Pai" />
                        <select id="inputParentTaskId" name="inputParentTaskId" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                            <option value="">Nenhuma (nível superior)</option>
                            @foreach($potentialParents as $parent)
                                <option value="{{$parent->id}}" {{ $task->parent_task_id == $parent->id ? 'selected' : '' }}>
                                    {{$parent->task_designation}} ({{$parent->project_designation}})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-v5-label for="inputTaskDescription" value="Descrição" />
                        <textarea id="inputTaskDescription" name="inputTaskDescription" rows="6" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white placeholder-dark-muted focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">{{ old('inputTaskDescription', $task->description) }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <x-v5-button type="submit">
                            <i class="fas fa-sync-alt mr-2"></i> Atualizar Tarefa
                        </x-v5-button>
                    </div>
                </form>
            </x-v5-card>

            {{-- Assigned Users Table --}}
            <x-v5-card>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-semibold text-white">Colaboradores</h3>
                    <x-v5-button size="sm" onclick="window.location.href='{{ route('users.AddToTask', ['project_id' => $task->id]) }}'">
                        <i class="fas fa-plus mr-2"></i> Adicionar
                    </x-v5-button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-dark-bg/50 text-dark-muted text-xs uppercase font-medium">
                            <tr>
                                <th class="px-6 py-3 font-semibold tracking-wider">Nome</th>
                                <th class="px-6 py-3 font-semibold tracking-wider">Email</th>
                                <th class="px-6 py-3 font-semibold tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dark-border">
                            @foreach ($users as $user)
                                <tr class="hover:bg-dark-border/30 transition">
                                    <td class="px-6 py-4 text-white">{{ $user->name ?? '--'}}</td>
                                    <td class="px-6 py-4 text-dark-muted text-sm">{{ $user->email ?? '--'}}</td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('users.removeFromTask', ['id' => $user->id]) }}" class="text-dark-muted hover:text-red-400 transition text-xs" onclick="return confirm('Remover utilizador da tarefa?')">
                                            <i class="fas fa-trash"></i> Remover
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            @if(count($users) == 0)
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-dark-muted text-sm italic">
                                        Nenhum colaborador atribuído a esta tarefa.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </x-v5-card>
        </div>

        <div class="space-y-8">
            <x-v5-card title="Ações Rápidas">
                <div class="flex flex-col gap-2">
                    <x-v5-button variant="secondary" size="sm" class="justify-start" onclick="window.location.href='{{ route('tasks.addDependency', ['task_id' => $task->id]) }}'">
                        <i class="fas fa-project-diagram mr-2 text-primary-400"></i> Dependências
                    </x-v5-button>
                    <x-v5-button variant="secondary" size="sm" class="justify-start" onclick="window.location.href='{{ route('tasks.addTraining', ['task_id' => $task->id]) }}'">
                        <i class="fas fa-graduation-cap mr-2 text-primary-400"></i> Formações
                    </x-v5-button>
                </div>
            </x-v5-card>

            <x-v5-card title="Zona de Perigo">
                <p class="text-xs text-dark-muted mb-4">A eliminação de uma tarefa remove-a de todas as listas e relatórios.</p>
                <x-v5-button variant="danger" size="sm" class="w-full" onclick="if(confirm('Tem a certeza?')) window.location.href='{{ route('tasks.delete', ['id' => $task->id]) }}'">
                    <i class="fas fa-trash mr-2"></i> Apagar Tarefa
                </x-v5-button>
            </x-v5-card>
        </div>
    </div>
@endsection
