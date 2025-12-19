@extends("layouts.app")

@section("title", "Novo Projeto")

@section("content")
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('projects.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Criar Novo Projeto</h1>
    </div>

    <div class="max-w-4xl">
        <x-v5-card>
            <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-v5-label for="inputProjectDesignation" value="Designação do Projeto" />
                        <x-v5-input id="inputProjectDesignation" name="inputProjectDesignation" placeholder="Ex: Website Redesign" required />
                    </div>
                    <div>
                        <x-v5-label for="inputProjectAcronimo" value="Acrónimo (Código)" />
                        <x-v5-input id="inputProjectAcronimo" name="inputProjectAcronimo" placeholder="Ex: WR-2024" required />
                    </div>
                </div>

                <div>
                    <x-v5-label for="inputProjectStatus" value="Estado do Projeto" />
                    <select id="inputProjectStatus" name="inputProjectStatus" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                        @foreach($PmStatus as $status)  
                            <option value="{{$status->status_designation}}">{{$status->status_designation}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-v5-label value="Seleccionar Equipas" />
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-dark-bg rounded-xl border border-dark-border">
                        @foreach($teams as $team)
                            <label class="flex items-center space-x-3 p-3 rounded-lg border border-dark-border hover:bg-dark-surface transition cursor-pointer group">
                                <input type="checkbox" name="inputProjectTeam[]" value="{{ $team->id }}" class="rounded bg-dark-bg border-dark-border text-primary-600 focus:ring-primary-500 focus:ring-offset-dark-surface transition">
                                <span class="text-sm text-dark-muted group-hover:text-white transition">{{ $team->team_designation }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <x-v5-label for="inputProjectDescription" value="Descrição Detalhada" />
                    <textarea id="inputProjectDescription" name="inputProjectDescription" rows="5" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white placeholder-dark-muted focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200" placeholder="Descreva os objetivos do projeto..."></textarea>
                </div>

                <div class="flex justify-end pt-4">
                    <x-v5-button type="submit">
                        <i class="fas fa-save mr-2"></i> Registrar Projeto
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>
    </div>
@endsection