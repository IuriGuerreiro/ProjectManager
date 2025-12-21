@extends("layouts.app")

@section("title", "Tarefas")

@section("content")
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Tarefas</h1>
            <p class="text-dark-muted text-sm mt-1">Lista hierárquica de todas as tarefas em todos os projetos.</p>
        </div>
        <x-v5-button onclick="window.location.href='{{ route('tasks.create') }}'">
            <i class="fas fa-plus mr-2"></i> Nova Tarefa
        </x-v5-button>
    </div>

    <div class="mb-6">
        <form action="{{ route('tasks.list') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <div class="relative">
                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? '' }}"
                        placeholder="Pesquisar por tarefa, código, descrição ou projeto..."
                        class="w-full px-4 py-2 pl-10 bg-dark-surface border border-dark-border rounded-lg text-sm text-white placeholder-dark-muted focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200"
                    >
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-dark-muted text-sm"></i>
                </div>
            </div>
            <button type="submit" class="px-6 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition duration-200 text-sm font-medium">
                <i class="fas fa-search mr-2"></i> Pesquisar
            </button>
            @if($search)
                <a href="{{ route('tasks.list') }}" class="px-6 py-2 bg-dark-surface hover:bg-dark-border text-white rounded-lg transition duration-200 text-sm font-medium border border-dark-border">
                    <i class="fas fa-times mr-2"></i> Limpar
                </a>
            @endif
        </form>
    </div>

    <x-v5-card>
        @if($tasks->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-search text-4xl text-dark-muted mb-4"></i>
                <p class="text-dark-muted">
                    @if($search)
                        Nenhuma tarefa encontrada para "{{ $search }}"
                    @else
                        Nenhuma tarefa encontrada
                    @endif
                </p>
                @if($search)
                    <a href="{{ route('tasks.list') }}" class="inline-block mt-4 text-primary-400 hover:text-primary-300">
                        <i class="fas fa-times-circle mr-2"></i>Limpar pesquisa
                    </a>
                @endif
            </div>
        @else
            <x-v5-table :headers="['Tarefa', 'Código', 'Estado', 'Projeto', 'Ações']">
                @foreach ($tasks as $task)
                    @include('tasks.partials.task-row', ['task' => $task, 'level' => 0])
                @endforeach
            </x-v5-table>
        @endif
    </x-v5-card>

    <script>
        function toggleSubtasks(taskId) {
            const subtaskRows = document.querySelectorAll(`[data-parent-id="${taskId}"]`);
            const toggleIcon = document.getElementById(`toggle-icon-${taskId}`);
            const isExpanded = toggleIcon.classList.contains('fa-chevron-down');

            if (isExpanded) {
                // Collapse
                toggleIcon.classList.remove('fa-chevron-down');
                toggleIcon.classList.add('fa-chevron-right');
                subtaskRows.forEach(row => {
                    row.classList.add('hidden');
                    // Also collapse any expanded children
                    const childTaskId = row.getAttribute('data-task-id');
                    const childIcon = document.getElementById(`toggle-icon-${childTaskId}`);
                    if (childIcon && childIcon.classList.contains('fa-chevron-down')) {
                        toggleSubtasks(childTaskId);
                    }
                });
            } else {
                // Expand
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-down');
                subtaskRows.forEach(row => {
                    row.classList.remove('hidden');
                });
            }
        }

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
                    // Optional: highlight success
                } else {
                    alert('Error updating status');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
