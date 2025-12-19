@extends('layouts.app')

@section('title', 'Atribuir Tarefa')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('tasks.view', ['id' => $task->id]) }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Atribuir Colaborador à Tarefa</h1>
    </div>

    <div class="max-w-2xl">
        <x-v5-card title="Tarefa: {{ $task->task_designation }}">
            <form action="{{ route('users.storeToTasks', ['project_id' => $task->id]) }}" method="POST" class="space-y-6">
                @csrf 
                <div>
                    <x-v5-label for="inputTaskuserId" value="Selecionar Colaborador" />
                    <select id="inputTaskuserId" name="inputTaskuserId" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-xs text-dark-muted">Apenas colaboradores das equipas associadas ao projeto podem ser atribuídos.</p>
                </div>

                <div class="flex justify-end pt-4">
                    <x-v5-button type="submit">
                        <i class="fas fa-user-plus mr-2"></i> Confirmar Atribuição
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>
    </div>
@endsection
