@extends('layouts.app')

@section('title', 'Criar Formação')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('trainings.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Nova Formação</h1>
    </div>

    <div class="max-w-4xl">
        <x-v5-card>
            <form action="{{ route('trainings.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-v5-label for="inputTrainingDesignation" value="Designação da Formação" />
                        <x-v5-input id="inputTrainingDesignation" name="inputTrainingDesignation" placeholder="Ex: Workshop Laravel" required />
                    </div>
                    <div>
                        <x-v5-label for="inputTrainingCode" value="Acrónimo / Código" />
                        <x-v5-input id="inputTrainingCode" name="inputTrainingCode" placeholder="Ex: LW-2024" required />
                    </div>
                </div>

                <div>
                    <x-v5-label for="inputTrainingStatus" value="Estado da Formação" />
                    <select id="inputTrainingStatus" name="inputTrainingStatus" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                        @foreach($PmStatus as $status)
                            <option value="{{$status->status_designation}}">{{$status->status_designation}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-v5-label for="inputTrainingDescription" value="Descrição da Formação" />
                    <textarea id="inputTrainingDescription" name="inputTrainingDescription" rows="4" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white placeholder-dark-muted focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200" placeholder="Detalhes sobre a formação..."></textarea>
                </div>

                <div>
                    <x-v5-label value="Selecionar Formadores" />
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-dark-bg rounded-xl border border-dark-border max-h-60 overflow-y-auto">
                        @forelse($formers as $former)
                            <label class="flex items-center space-x-3 p-3 rounded-lg border border-dark-border hover:bg-dark-surface transition cursor-pointer group">
                                <input type="checkbox" name="inputTrainingFormer[]" value="{{ $former->id }}" class="rounded bg-dark-bg border-dark-border text-primary-600 focus:ring-primary-500 focus:ring-offset-dark-surface transition">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-white group-hover:text-primary-400 transition">{{ $former->name }}</span>
                                    <span class="text-xs text-dark-muted">{{ $former->email }}</span>
                                </div>
                            </label>
                        @empty
                            <p class="text-sm text-dark-muted col-span-2 text-center py-4">Nenhum formador disponível. Crie um primeiro.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <x-v5-label value="Equipas com Acesso (obrigatório)" />
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-dark-bg rounded-xl border border-dark-border max-h-48 overflow-y-auto" id="teamsContainer">
                        @foreach($teams as $team)
                            <label class="flex items-center space-x-3 p-3 rounded-lg border border-dark-border hover:bg-dark-surface transition cursor-pointer group">
                                <input type="checkbox" name="inputTrainingTeams[]" value="{{ $team->id }}" class="rounded bg-dark-bg border-dark-border text-primary-600 focus:ring-primary-500 focus:ring-offset-dark-surface transition team-checkbox">
                                <span class="text-sm font-medium text-white group-hover:text-primary-400 transition">{{ $team->team_designation }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-dark-muted mt-1">Selecione pelo menos uma equipa para dar acesso à formação</p>
                    <p class="text-xs text-red-500 mt-1 hidden" id="teamError">Por favor, selecione pelo menos uma equipa</p>
                </div>

                <div>
                    <x-v5-label value="Selecionar Participantes (Utilizadores)" />
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-dark-bg rounded-xl border border-dark-border max-h-60 overflow-y-auto">
                        @foreach($users as $user)
                            <label class="flex items-center space-x-3 p-3 rounded-lg border border-dark-border hover:bg-dark-surface transition cursor-pointer group">
                                <input type="checkbox" name="inputTrainingUser[]" value="{{ $user->id }}" class="rounded bg-dark-bg border-dark-border text-primary-600 focus:ring-primary-500 focus:ring-offset-dark-surface transition">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-white group-hover:text-primary-400 transition">{{ $user->name }}</span>
                                    <span class="text-xs text-dark-muted">{{ $user->email }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <x-v5-button type="submit">
                        <i class="fas fa-save mr-2"></i> Criar Formação
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
