@extends('layouts.app')

@section('title', 'Adicionar Formador')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('formers.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Novo Formador</h1>
    </div>

    <div class="max-w-4xl">
        <x-v5-card title="Dados do Formador">
            <form action="{{ route('formers.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-v5-label for="inputFormerName" value="Nome Completo" />
                        <x-v5-input id="inputFormerName" name="inputFormerName" placeholder="Ex: João Silva" required />
                    </div>
                    <div>
                        <x-v5-label for="inputFormerEmail" value="Email Profissional" />
                        <x-v5-input id="inputFormerEmail" name="inputFormerEmail" type="email" placeholder="Ex: joao.silva@empresa.com" required />
                    </div>
                </div>

                <div>
                    <x-v5-label value="Equipas com Acesso (obrigatório)" />
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-dark-bg rounded-xl border border-dark-border max-h-48 overflow-y-auto" id="teamsContainer">
                        @foreach($teams as $team)
                            <label class="flex items-center space-x-3 p-3 rounded-lg border border-dark-border hover:bg-dark-surface transition cursor-pointer group">
                                <input type="checkbox" name="inputFormerTeams[]" value="{{ $team->id }}" class="rounded bg-dark-bg border-dark-border text-primary-600 focus:ring-primary-500 focus:ring-offset-dark-surface transition team-checkbox">
                                <span class="text-sm font-medium text-white group-hover:text-primary-400 transition">{{ $team->team_designation }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-dark-muted mt-1">Selecione pelo menos uma equipa para dar acesso ao formador</p>
                    <p class="text-xs text-red-500 mt-1 hidden" id="teamError">Por favor, selecione pelo menos uma equipa</p>
                </div>

                <div>
                    <x-v5-label value="Atribuir a Formações (opcional)" />
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-dark-bg rounded-xl border border-dark-border max-h-60 overflow-y-auto">
                        @forelse($trainings as $training)
                            <label class="flex items-center space-x-3 p-3 rounded-lg border border-dark-border hover:bg-dark-surface transition cursor-pointer group">
                                <input type="checkbox" name="inputFormerTrainings[]" value="{{ $training->id }}" class="rounded bg-dark-bg border-dark-border text-primary-600 focus:ring-primary-500 focus:ring-offset-dark-surface transition">
                                <span class="text-sm text-dark-muted group-hover:text-white transition">{{ $training->trainings_designation }}</span>
                            </label>
                        @empty
                            <p class="text-sm text-dark-muted col-span-2 text-center py-4">Nenhuma formação disponível nas suas equipas.</p>
                        @endforelse
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <x-v5-button type="submit">
                        <i class="fas fa-save mr-2"></i> Registrar Formador
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const teamCheckboxes = document.querySelectorAll('.team-checkbox');
            const isAnyChecked = Array.from(teamCheckboxes).some(cb => cb.checked);
            const errorMsg = document.getElementById('teamError');

            if (!isAnyChecked) {
                e.preventDefault();
                errorMsg.classList.remove('hidden');
                document.getElementById('teamsContainer').scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                errorMsg.classList.add('hidden');
            }
        });
    </script>
@endsection
