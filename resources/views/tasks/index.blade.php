@extends("layouts.app")

@section("title", "Tarefas")

@section("content")
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Tarefas</h1>
            <p class="text-dark-muted text-sm mt-1">Lista global de todas as tarefas em todos os projetos.</p>
        </div>
        <x-v5-button onclick="window.location.href='{{ route('tasks.create') }}'">
            <i class="fas fa-plus mr-2"></i> Nova Tarefa
        </x-v5-button>
    </div>

    <x-v5-card>
        <x-v5-table :headers="['Código', 'Tarefa', 'Estado', 'Projeto', 'Ações']">
            @foreach ($tasks as $task)
                <tr class="hover:bg-dark-border/30 transition duration-200">
                    <td class="px-6 py-4">
                        <span class="font-mono text-xs text-primary-400 bg-primary-500/10 px-2 py-1 rounded border border-primary-500/20">
                            {{ $task->task_code ?? "--" }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-white">{{ $task->task_designation ?? "--" }}</div>
                        <div class="text-xs text-dark-muted mt-0.5">{{ \Str::limit($task->description, 40) ?? "--" }}</div>
                    </td>
                    <td class="px-6 py-4">
                         <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dark-bg text-dark-muted border border-dark-border">
                            {{ $task->task_status ?? "--" }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('tasks.listbyProject', ['project_id' => $task->project_id]) }}" class="text-primary-400 hover:text-primary-300 transition text-sm">
                            {{ $task->project_designation ?? "--" }}
                        </a>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('tasks.view', ['id' => $task->id]) }}" class="text-dark-muted hover:text-primary-400 transition">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" class="text-dark-muted hover:text-yellow-400 transition">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('tasks.delete', ['id' => $task->id]) }}" onclick="return confirm('Tem a certeza?')" class="text-dark-muted hover:text-red-400 transition">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-v5-table>
    </x-v5-card>
@endsection