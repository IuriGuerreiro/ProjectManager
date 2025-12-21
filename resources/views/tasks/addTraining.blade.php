@extends('layouts.app')

@section('title', 'Gerir Formações Obrigatórias')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('tasks.view', ['id' => $task->id]) }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Gerir Formações Obrigatórias</h1>
            <p class="text-dark-muted text-sm mt-1">Tarefa: <span class="text-primary-400">{{ $task->task_designation }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <x-v5-card title="Adicionar Formações Obrigatórias">
            <form action="{{ route('tasks.storeTraining', ['task_id' => $task->id]) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <x-v5-label value="Selecione as formações obrigatórias" />
                    <div class="grid grid-cols-1 gap-3 p-4 bg-dark-bg rounded-xl border border-dark-border max-h-60 overflow-y-auto">
                        @forelse($availableTrainings as $training)
                            <label class="flex items-center space-x-3 p-3 rounded-lg border border-dark-border hover:bg-dark-surface transition cursor-pointer group">
                                <input type="checkbox" name="training_ids[]" value="{{ $training->id }}" class="rounded bg-dark-bg border-dark-border text-primary-600 focus:ring-primary-500 focus:ring-offset-dark-surface transition">
                                <span class="text-sm text-white group-hover:text-primary-400 transition">{{ $training->trainings_designation }}</span>
                            </label>
                        @empty
                            <p class="text-sm text-dark-muted text-center py-4">Todas as formações já estão configuradas.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <x-v5-label for="required_for_status" value="Obrigatória para estado (opcional)" />
                    <select name="required_for_status" id="required_for_status" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                        <option value="">Todos os estados</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->status_designation }}">{{ $status->status_designation }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-dark-muted mt-1">Especifique um estado específico ou deixe vazio para aplicar a todos</p>
                </div>

                @if($availableTrainings->count() > 0)
                    <div class="flex justify-end pt-4">
                        <x-v5-button type="submit">
                            <i class="fas fa-plus mr-2"></i> Adicionar Formações
                        </x-v5-button>
                    </div>
                @endif
            </form>
        </x-v5-card>

        <x-v5-card title="Formações Obrigatórias Atuais">
            <x-v5-table :headers="['Formação', 'Obrigatória Para', 'Ações']">
                @forelse($existingTrainings as $training)
                    <tr class="hover:bg-dark-border/30 transition duration-200">
                        <td class="px-6 py-4 font-medium text-white">{{ $training->trainings_designation }}</td>
                        <td class="px-6 py-4 text-dark-muted">{{ $training->pivot->required_for_status ?? 'Todos os estados' }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('tasks.removeTraining', ['id' => $training->pivot->id]) }}"
                               onclick="return confirm('Remover esta formação obrigatória?')"
                               class="text-red-400 hover:text-red-300 transition">
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
@endsection
