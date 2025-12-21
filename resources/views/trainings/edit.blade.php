@extends('layouts.app')

@section('title', 'Gerir Formação')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('trainings.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Gerir Formação</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <x-v5-card title="Editar Formação">
                <form action="{{ route('trainings.update', ['training_id' => $training->id]) }}" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <x-v5-label for="inputTrainingDesignation" value="Designação da Formação" />
                            <x-v5-input id="inputTrainingDesignation" name="inputTrainingDesignation" value="{{ $training->trainings_designation }}" placeholder="Ex: Workshop Laravel" required />
                        </div>
                    </div>

                    <div>
                        <x-v5-label for="inputTrainingStatus" value="Estado da Formação" />
                        <select id="inputTrainingStatus" name="inputTrainingStatus" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                            @foreach($PmStatus as $status)
                                <option value="{{$status->status_designation}}" {{ $training->status == $status->status_designation ? 'selected' : '' }}>{{$status->status_designation}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-v5-label for="inputTrainingDescription" value="Descrição da Formação" />
                        <textarea id="inputTrainingDescription" name="inputTrainingDescription" rows="4" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white placeholder-dark-muted focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200" placeholder="Detalhes sobre a formação...">{{ $training->description }}</textarea>
                    </div>

                    <div>
                        <x-v5-label value="Equipas com Acesso (obrigatório)" />
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-4 bg-dark-bg rounded-xl border border-dark-border max-h-48 overflow-y-auto" id="teamsContainer">
                            @foreach($teams as $team)
                                <label class="flex items-center space-x-3 p-3 rounded-lg border border-dark-border hover:bg-dark-surface transition cursor-pointer group">
                                    <input type="checkbox" name="inputTrainingTeams[]" value="{{ $team->id }}"
                                        {{ in_array($team->id, $assignedTeams) ? 'checked' : '' }}
                                        class="rounded bg-dark-bg border-dark-border text-primary-600 focus:ring-primary-500 focus:ring-offset-dark-surface transition team-checkbox">
                                    <span class="text-sm font-medium text-white group-hover:text-primary-400 transition">{{ $team->team_designation }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-dark-muted mt-1">Selecione pelo menos uma equipa para dar acesso à formação</p>
                        <p class="text-xs text-red-500 mt-1 hidden" id="teamError">Por favor, selecione pelo menos uma equipa</p>
                    </div>

                    <div class="flex justify-end pt-4">
                        <x-v5-button type="submit">
                            <i class="fas fa-save mr-2"></i> Guardar Alterações
                        </x-v5-button>
                    </div>
                </form>
            </x-v5-card>

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

            <x-v5-card title="Utilizadores Inscritos">
                <x-slot name="action">
                    <x-v5-button size="sm" variant="secondary" onclick="window.location.href='{{ route('trainings.addUsers', ['training_id' => $training->id]) }}'">
                        <i class="fas fa-plus mr-2"></i> Adicionar
                    </x-v5-button>
                </x-slot>

                <x-v5-table :headers="['Nome', 'Email']">
                    @forelse ($users as $user)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4 text-white">{{ $user->name ?? "--" }}</td>
                            <td class="px-6 py-4 text-dark-muted">{{ $user->email ?? "--" }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">Nenhum utilizador.</td>
                        </tr>
                    @endforelse
                </x-v5-table>
            </x-v5-card>

            <x-v5-card title="Formadores Atribuídos">
                <x-v5-table :headers="['Nome', 'Email']">
                    @forelse ($formers as $former)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4 text-white">{{ $former->name ?? "--" }}</td>
                            <td class="px-6 py-4 text-dark-muted">{{ $former->email ?? "--" }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">Nenhum formador.</td>
                        </tr>
                    @endforelse
                </x-v5-table>
            </x-v5-card>
        </div>

        <div class="space-y-8">
            <x-v5-card title="Informação da Formação">
                <div class="space-y-4">
                    <div>
                        <x-v5-label value="Código" />
                        <span class="form-control bg-dark-bg border-dark-border text-primary-400 font-mono">{{ $training->trainings_code }}</span>
                    </div>
                    <div>
                        <x-v5-label value="Criado por" />
                        <span class="form-control bg-dark-bg border-dark-border text-white">{{ $training->creator->name ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <x-v5-label value="Data de Criação" />
                        <span class="form-control bg-dark-bg border-dark-border text-dark-muted">{{ $training->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </x-v5-card>
        </div>
    </div>
@endsection
