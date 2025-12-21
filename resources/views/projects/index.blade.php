@extends("layouts.app")

@section("title", "Lista de Projetos")

@section("content")
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Projetos</h1>
            <p class="text-dark-muted text-sm mt-1">Gerencie todos os projetos ativos da sua organização.</p>
        </div>
        <x-v5-button href="{{ route('projects.create') }}">
            <i class="fas fa-plus mr-2"></i> Novo Projeto
        </x-v5-button>
    </div>

    <x-v5-card>
        <x-v5-table :headers="['Código', 'Designação', 'Estado', 'Equipas', 'Ações']">
            @foreach ($projects as $project)
                <tr class="hover:bg-dark-border/30 transition duration-200">
                    <td class="px-6 py-4">
                        <span class="font-mono text-xs text-primary-400 bg-primary-500/10 px-2 py-1 rounded border border-primary-500/20">
                            {{ $project->project_code ?? "--" }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-white">{{ $project->project_designation ?? "--" }}</div>
                        <div class="text-xs text-dark-muted mt-1">{{ \Str::limit($project->description, 50) ?? "--" }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <select onchange="updateProjectStatus({{ $project->id }}, this.value)" class="bg-dark-bg text-xs border border-dark-border rounded px-2 py-1 text-white focus:ring-primary-500 focus:border-primary-500 block w-full">
                            @foreach($statuses as $status)
                                <option value="{{ $status->status_designation }}" {{ $project->project_status == $status->status_designation ? 'selected' : '' }}>
                                    {{ $status->status_designation }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex -space-x-2">
                             <div class="w-7 h-7 rounded-full bg-dark-bg border border-dark-border flex items-center justify-center text-[10px] text-dark-muted">
                                <i class="fas fa-users"></i>
                             </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route("projects.view", ["id" => $project->id]) }}" class="text-dark-muted hover:text-primary-400 transition">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route("projects.edit", ["id" => $project->id]) }}" class="text-dark-muted hover:text-yellow-400 transition">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route("projects.delete", ["id" => $project->id]) }}" onclick="return confirm('Tem a certeza?')" class="text-dark-muted hover:text-red-400 transition">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-v5-table>
    </x-v5-card>

    <script>
        function updateProjectStatus(id, newStatus) {
            fetch(`/Project/${id}/update-status`, {
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
                    // Optional: show a toast or highlight success
                } else {
                    alert('Error updating status');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
@endsection
