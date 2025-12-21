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
            <p class="text-3xl font-bold text-white">{{ $activeProjects }}</p>
            <a href="{{ route('projects.list') }}" class="text-xs text-primary-400 mt-2 hover:text-primary-300 transition">Ver todos <i class="fas fa-arrow-right ml-1"></i></a>
        </x-v5-card>

        <x-v5-card class="hover:border-primary-500/30 transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-dark-muted text-sm font-medium uppercase tracking-wider">Minhas Tarefas</h3>
                <div class="w-8 h-8 rounded-lg bg-yellow-500/10 flex items-center justify-center text-yellow-400">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">{{ $myTasks }}</p>
            <a href="{{ route('tasks.list') }}" class="text-xs text-yellow-400 mt-2 hover:text-yellow-300 transition">Ver tarefas <i class="fas fa-arrow-right ml-1"></i></a>
        </x-v5-card>

        <x-v5-card class="hover:border-primary-500/30 transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-dark-muted text-sm font-medium uppercase tracking-wider">Membros da Equipa</h3>
                <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-400">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">{{ $teamMembers }}</p>
            <a href="{{ route('teams.list') }}" class="text-xs text-purple-400 mt-2 hover:text-purple-300 transition">Ver equipas <i class="fas fa-arrow-right ml-1"></i></a>
        </x-v5-card>

        <x-v5-card class="hover:border-primary-500/30 transition duration-300">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-dark-muted text-sm font-medium uppercase tracking-wider">Formações</h3>
                <div class="w-8 h-8 rounded-lg bg-green-500/10 flex items-center justify-center text-green-400">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>
            <p class="text-3xl font-bold text-white">{{ $availableTrainings }}</p>
            <a href="{{ route('trainings.list') }}" class="text-xs text-green-400 mt-2 hover:text-green-300 transition">Ver formações <i class="fas fa-arrow-right ml-1"></i></a>
        </x-v5-card>
    </div>

    <!-- My Tasks Section -->
    <div>
        <x-v5-card title="Minhas Tarefas">
            <x-slot name="action">
                <a href="{{ route('tasks.list') }}" class="text-primary-400 text-sm font-medium hover:text-primary-300 transition">Ver todas</a>
            </x-slot>

            <x-v5-table :headers="['Tarefa', 'Projeto', 'Estado', 'Ações']">
                @forelse($myPriorityTasks as $task)
                    <tr class="hover:bg-dark-border/30 transition duration-200">
                        <td class="px-6 py-4">
                            <span class="font-medium text-white">{{ $task->task_designation }}</span>
                        </td>
                        <td class="px-6 py-4 text-dark-muted">
                            {{ $task->project_designation }}
                        </td>
                        <td class="px-6 py-4">
                            <select onchange="updateTaskStatus({{ $task->id }}, this.value)" class="bg-dark-bg text-xs border border-dark-border rounded px-2 py-1 text-white focus:ring-primary-500 focus:border-primary-500 block w-full">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->status_designation }}" {{ $task->task_status == $status->status_designation ? 'selected' : '' }}>
                                        {{ $status->status_designation }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('tasks.view', ['id' => $task->id]) }}" class="text-primary-400 hover:text-primary-300 transition">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                            Nenhuma tarefa atribuída. <a href="{{ route('tasks.create') }}" class="text-primary-400 hover:text-primary-300">Criar primeira tarefa</a>
                        </td>
                    </tr>
                @endforelse
            </x-v5-table>
        </x-v5-card>
    </div>

    <script>
        function updateTaskStatus(id, newStatus) {
            fetch(`/task/${id}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Optional: show success feedback
                } else {
                    alert('Erro ao atualizar estado');
                    location.reload(); // Reload to revert dropdown
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erro ao atualizar estado');
                location.reload(); // Reload to revert dropdown
            });
        }
    </script>
@endsection