@extends('layouts.app')

@section('title', 'Criar Tarefa')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('tasks.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Criar Nova Tarefa</h1>
    </div>

    <div class="max-w-4xl">
        <x-v5-card>
            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-v5-label for="inputTaskDesignation" value="Designação da Tarefa" />
                        <x-v5-input id="inputTaskDesignation" name="inputTaskDesignation" placeholder="Ex: Implementar Login" required />
                    </div>
                    <div>
                        <x-v5-label for="inputTaskAcronomico" value="Acrónimo" />
                        <x-v5-input id="inputTaskAcronomico" name="inputTaskAcronomico" placeholder="Ex: TSK-001" required />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-v5-label for="inputTaskStatus" value="Estado" />
                        <select id="inputTaskStatus" name="inputTaskStatus" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                            @foreach($PmStatus as $status)  
                                <option value="{{$status->status_designation}}">{{$status->status_designation}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-v5-label for="inputTaskProjectId" value="Projeto Associado" />
                        <select id="inputTaskProjectId" name="inputTaskProjectId" onchange="fetchProjectUsers(this.value)" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                            <option value="">Selecione um projeto...</option>
                            @foreach($projects as $project)  
                                <option value="{{$project->id}}">{{$project->project_designation}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <x-v5-label value="Atribuir a Utilizadores" />
                    <div id="users-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-dark-bg rounded-xl border border-dark-border max-h-60 overflow-y-auto">
                        <p class="text-sm text-dark-muted col-span-2 text-center py-4">Selecione um projeto para ver os membros da equipa.</p>
                        <!-- Users will be populated here via JS -->
                    </div>
                </div>

                <div>
                    <x-v5-label for="inputTaskDescription" value="Descrição" />
                    <textarea id="inputTaskDescription" name="inputTaskDescription" rows="4" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white placeholder-dark-muted focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200" placeholder="Detalhes da tarefa..."></textarea>
                </div>

                <div class="flex justify-end pt-4">
                    <x-v5-button type="submit">
                        <i class="fas fa-save mr-2"></i> Criar Tarefa
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>
    </div>

    <script>
        function fetchProjectUsers(projectId) {
            const grid = document.getElementById('users-grid');
            
            if (!projectId) {
                grid.innerHTML = '<p class="text-sm text-dark-muted col-span-2 text-center py-4">Selecione um projeto para ver os membros da equipa.</p>';
                return;
            }

            grid.innerHTML = '<p class="text-sm text-dark-muted col-span-2 text-center py-4"><i class="fas fa-spinner fa-spin mr-2"></i> Carregando membros...</p>';

            fetch(`/Project/${projectId}/users`)
                .then(response => response.json())
                .then(users => {
                    grid.innerHTML = '';
                    if (users.length === 0) {
                        grid.innerHTML = '<p class="text-sm text-dark-muted col-span-2 text-center py-4">Nenhum membro encontrado nas equipas deste projeto.</p>';
                        return;
                    }

                    users.forEach(user => {
                        const label = document.createElement('label');
                        label.className = 'flex items-center space-x-3 p-3 rounded-lg border border-dark-border hover:bg-dark-surface transition cursor-pointer group';
                        label.innerHTML = `
                            <input type="checkbox" name="inputTaskUsers[]" value="${user.id}" class="rounded bg-dark-bg border-dark-border text-primary-600 focus:ring-primary-500 focus:ring-offset-dark-surface transition">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-white group-hover:text-primary-400 transition">${user.name}</span>
                                <span class="text-xs text-dark-muted">${user.email}</span>
                            </div>
                        `;
                        grid.appendChild(label);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    grid.innerHTML = '<p class="text-sm text-red-400 col-span-2 text-center py-4">Erro ao carregar utilizadores.</p>';
                });
        }
    </script>
@endsection
