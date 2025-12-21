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

    <x-v5-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-dark-border">
                <thead class="bg-dark-surface">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-dark-muted uppercase tracking-wider">Tarefa</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-dark-muted uppercase tracking-wider">Código</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-dark-muted uppercase tracking-wider">Estado</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-dark-muted uppercase tracking-wider">Projeto</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-dark-muted uppercase tracking-wider">Progresso</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-dark-muted uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-dark-bg divide-y divide-dark-border">
                    @foreach ($tasks as $task)
                        @include('tasks.partials.task-row', ['task' => $task, 'level' => 0])
                    @endforeach
                </tbody>
            </table>
        </div>
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
    </script>
@endsection
