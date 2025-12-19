@extends("layouts.app")

@section("title", "Detalhes do Projeto")

@section("content")
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('projects.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">{{ $project->project_designation }}</h1>
                <p class="text-dark-muted text-sm mt-1">Código: <span class="text-primary-400 font-mono">{{ $project->project_code }}</span></p>
            </div>
        </div>
        <div class="flex gap-3">
             <x-v5-button variant="secondary" onclick="window.location.href='{{ route('projects.edit', ['id' => $project->id]) }}'">
                <i class="fas fa-edit mr-2"></i> Editar
            </x-v5-button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Info -->
        <div class="lg:col-span-2 space-y-8">
            <x-v5-card title="Descrição do Projeto">
                <div class="prose prose-invert max-w-none text-dark-muted leading-relaxed">
                    {{ $project->description ?? "Nenhuma descrição fornecida." }}
                </div>
            </x-v5-card>

            <x-v5-card title="Equipas Associadas">
                <x-v5-table :headers="['Equipa', 'Função', 'Membros']">
                    @forelse ($teams as $team)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4 font-medium text-white">{{ $team->team_designation ?? "--" }}</td>
                            <td class="px-6 py-4 text-dark-muted">{{ $team->team_function ?? "--" }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs bg-dark-bg px-2 py-1 rounded border border-dark-border">N/A</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                                Nenhuma equipa associada a este projeto.
                            </td>
                        </tr>
                    @endforelse
                </x-v5-table>
            </x-v5-card>

            <x-v5-card title="Tarefas do Projeto">
                <x-v5-table :headers="['Tarefa', 'Estado', 'Responsável']">
                    @forelse ($tasks as $task)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ $task->task_designation }}</div>
                                <div class="text-xs text-dark-muted mt-0.5">{{ $task->task_code }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-dark-bg text-dark-muted border border-dark-border">
                                    {{ $task->task_status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-dark-muted">--</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                                Nenhuma tarefa criada para este projeto.
                            </td>
                        </tr>
                    @endforelse
                </x-v5-table>
            </x-v5-card>
        </div>

        <!-- Right Column: Sidebar Stats -->
        <div class="space-y-8">
            <x-v5-card title="Status Geral">
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-dark-muted">Estado Atual</span>
                            <span class="text-primary-400 font-medium">{{ $project->project_status }}</span>
                        </div>
                        <div class="w-full bg-dark-bg h-2 rounded-full overflow-hidden">
                             <div class="bg-primary-500 h-full" style="width: 60%"></div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-dark-border">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs font-bold text-dark-muted uppercase tracking-wider">Metricas</span>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-dark-bg p-3 rounded-xl border border-dark-border">
                                <div class="text-xl font-bold text-white">{{ count($tasks) }}</div>
                                <div class="text-[10px] text-dark-muted uppercase tracking-wide mt-1">Total Tarefas</div>
                            </div>
                            <div class="bg-dark-bg p-3 rounded-xl border border-dark-border">
                                <div class="text-xl font-bold text-white">{{ count($teams) }}</div>
                                <div class="text-[10px] text-dark-muted uppercase tracking-wide mt-1">Equipas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-v5-card>

            <x-v5-card title="Ações Rápidas">
                <div class="flex flex-col gap-2">
                    <x-v5-button variant="secondary" size="sm" class="justify-start">
                        <i class="fas fa-plus mr-2"></i> Criar Nova Tarefa
                    </x-v5-button>
                    <x-v5-button variant="secondary" size="sm" class="justify-start">
                        <i class="fas fa-user-plus mr-2"></i> Gerir Equipas
                    </x-v5-button>
                    <x-v5-button variant="danger" size="sm" class="justify-start" onclick="return confirm('Apagar projeto?')">
                        <i class="fas fa-trash mr-2"></i> Apagar Projeto
                    </x-v5-button>
                </div>
            </x-v5-card>
        </div>
    </div>
@endsection