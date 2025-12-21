{{-- Recursive task row partial - supports infinite nesting --}}
<tr class="hover:bg-dark-border/30 transition duration-200" data-task-id="{{ $task->id }}" @if(isset($parentId)) data-parent-id="{{ $parentId }}" @endif>
    <td class="px-6 py-4">
        <div class="flex items-center gap-2" style="padding-left: {{ $level * 24 }}px;">
            @if($task->subtasks->count() > 0)
                <button onclick="toggleSubtasks({{ $task->id }})" class="text-dark-muted hover:text-white transition focus:outline-none">
                    <i id="toggle-icon-{{ $task->id }}" class="fas fa-chevron-right text-xs"></i>
                </button>
            @else
                <span class="w-4"></span>
            @endif

            <div class="flex items-center gap-2">
                @if($level > 0)
                    <i class="fas fa-level-up-alt fa-rotate-90 text-dark-muted text-xs"></i>
                @endif
                <div>
                    <div class="font-medium text-white">{{ $task->task_designation ?? "--" }}</div>
                    <div class="text-xs text-dark-muted mt-0.5">{{ \Str::limit($task->description, 40) ?? "--" }}</div>
                </div>
            </div>
        </div>
    </td>
    <td class="px-6 py-4">
        <span class="font-mono text-xs text-primary-400 bg-primary-500/10 px-2 py-1 rounded border border-primary-500/20">
            {{ $task->task_code ?? "--" }}
        </span>
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
    <td class="px-6 py-4">
        @if(isset($task->project_designation))
            <a href="{{ route('tasks.listbyProject', ['project_id' => $task->project_id]) }}" class="text-primary-400 hover:text-primary-300 transition text-sm">
                {{ $task->project_designation }}
            </a>
        @else
            <span class="text-dark-muted text-sm">{{ $task->project->project_designation ?? "--" }}</span>
        @endif
    </td>
    <td class="px-6 py-4 text-right space-x-2">
        <a href="{{ route('tasks.view', ['id' => $task->id]) }}" class="text-dark-muted hover:text-primary-400 transition" title="Ver Detalhes">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('tasks.edit', ['id' => $task->id]) }}" class="text-dark-muted hover:text-yellow-400 transition" title="Editar">
            <i class="fas fa-edit"></i>
        </a>
        <a href="{{ route('tasks.delete', ['id' => $task->id]) }}" onclick="return confirm('Tem a certeza?')" class="text-dark-muted hover:text-red-400 transition" title="Apagar">
            <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>

{{-- Recursively render subtasks --}}
@if($task->subtasks->count() > 0)
    @foreach($task->subtasks as $subtask)
        @include('tasks.partials.task-row', [
            'task' => $subtask,
            'level' => $level + 1,
            'parentId' => $task->id
        ])
    @endforeach
@endif
