@extends('layouts.app')

@section('title', 'Gerir Dependências da Tarefa')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('tasks.view', ['id' => $task->id]) }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Gerir Dependências</h1>
            <p class="text-dark-muted text-sm mt-1">Tarefa: <span class="text-primary-400">{{ $task->task_designation }}</span></p>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
            <p class="text-sm text-red-400">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ $errors->first() }}
            </p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <x-v5-card title="Adicionar Nova Dependência">
            <form action="{{ route('tasks.storeDependency', ['task_id' => $task->id]) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <x-v5-label value="Esta tarefa depende de:" />
                    <select name="depends_on_task_id" required class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                        <option value="">Selecione uma tarefa...</option>
                        @foreach($availableTasks as $availableTask)
                            <option value="{{ $availableTask->id }}">{{ $availableTask->task_designation }}</option>
                        @endforeach
                    </select>
                </div>

                @if($availableTasks->count() > 0)
                    <div class="flex justify-end pt-4">
                        <x-v5-button type="submit">
                            <i class="fas fa-plus mr-2"></i> Adicionar Dependência
                        </x-v5-button>
                    </div>
                @else
                    <p class="text-sm text-dark-muted text-center py-4">Todas as tarefas disponíveis já estão como dependências.</p>
                @endif
            </form>
        </x-v5-card>

        <x-v5-card title="Dependências Atuais">
            <x-v5-table :headers="['Tarefa', 'Estado', 'Ações']">
                @forelse($existingDependencies as $dependency)
                    <tr class="hover:bg-dark-border/30 transition duration-200">
                        <td class="px-6 py-4 font-medium text-white">{{ $dependency->task_designation }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dark-bg text-dark-muted border border-dark-border">
                                {{ $dependency->task_status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('tasks.removeDependency', ['id' => $dependency->pivot->id]) }}"
                               onclick="return confirm('Remover esta dependência?')"
                               class="text-red-400 hover:text-red-300 transition">
                                <i class="fas fa-unlink"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                            Nenhuma dependência configurada.
                        </td>
                    </tr>
                @endforelse
            </x-v5-table>
        </x-v5-card>
    </div>
@endsection
