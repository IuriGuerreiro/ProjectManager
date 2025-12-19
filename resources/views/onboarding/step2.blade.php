<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-white mb-2">Configure a Sua Equipa</h1>
        <p class="text-dark-muted text-sm">Crie uma nova equipa ou junte-se a uma existente</p>

        <div class="flex justify-center items-center gap-3 mt-6">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <span class="ml-2 text-dark-muted text-sm">Info</span>
            </div>
            <div class="w-8 h-0.5 bg-dark-border"></div>
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-primary-500 text-white flex items-center justify-center font-bold text-sm">2</div>
                <span class="ml-2 text-white text-sm font-medium">Equipa</span>
            </div>
        </div>
    </div>

    <form action="{{ route('onboarding.processStep2') }}" method="POST" class="space-y-6" x-data="{ teamAction: 'create' }">
        @csrf

        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold text-white mb-2">Escolha uma Opção</h2>
            <p class="text-sm text-dark-muted">As equipas permitem colaborar com outros utilizadores em projetos</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <label class="relative flex flex-col items-center p-6 bg-dark-bg border-2 rounded-xl cursor-pointer transition hover:border-primary-500"
                   :class="teamAction === 'create' ? 'border-primary-500 bg-primary-500/5' : 'border-dark-border'">
                <input type="radio" name="team_action" value="create" x-model="teamAction" class="sr-only" checked>
                <div class="w-12 h-12 rounded-full bg-primary-500/10 flex items-center justify-center mb-3">
                    <i class="fas fa-plus text-2xl text-primary-400"></i>
                </div>
                <span class="text-white font-medium">Criar Nova Equipa</span>
                <span class="text-xs text-dark-muted mt-1 text-center">Inicie uma equipa do zero</span>
            </label>

            <label class="relative flex flex-col items-center p-6 bg-dark-bg border-2 rounded-xl cursor-pointer transition hover:border-primary-500"
                   :class="teamAction === 'join' ? 'border-primary-500 bg-primary-500/5' : 'border-dark-border'">
                <input type="radio" name="team_action" value="join" x-model="teamAction" class="sr-only">
                <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center mb-3">
                    <i class="fas fa-users text-2xl text-blue-400"></i>
                </div>
                <span class="text-white font-medium">Juntar-se a Equipa</span>
                <span class="text-xs text-dark-muted mt-1 text-center">Una-se a uma equipa existente</span>
            </label>
        </div>

        @error('team_action')
            <p class="text-sm text-red-400">{{ $message }}</p>
        @enderror

        <div x-show="teamAction === 'create'" x-transition>
            <x-v5-label for="new_team_name" value="Nome da Nova Equipa *" />
            <x-v5-input
                id="new_team_name"
                name="new_team_name"
                type="text"
                placeholder="Ex: Equipa de Desenvolvimento, Marketing"
                value="{{ old('new_team_name') }}"
            />
            @error('new_team_name')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div x-show="teamAction === 'join'" x-transition>
            <x-v5-label for="existing_team_id" value="Selecionar Equipa *" />
            @if($existingTeams->count() > 0)
                <select id="existing_team_id" name="existing_team_id" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                    <option value="">Escolha uma equipa...</option>
                    @foreach($existingTeams as $team)
                        <option value="{{ $team->id }}" {{ old('existing_team_id') == $team->id ? 'selected' : '' }}>
                            {{ $team->team_designation }}
                        </option>
                    @endforeach
                </select>
            @else
                <div class="p-4 bg-yellow-500/10 border border-yellow-500/20 rounded-lg">
                    <p class="text-sm text-yellow-400">
                        <i class="fas fa-info-circle mr-2"></i>
                        Ainda não existem equipas. Por favor, crie uma nova equipa.
                    </p>
                </div>
            @endif
            @error('existing_team_id')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col sm:flex-row gap-4 pt-6">
            <a href="{{ route('onboarding.skip') }}" class="flex-1 text-center px-6 py-3 bg-dark-surface border border-dark-border rounded-lg text-dark-muted hover:text-white hover:border-primary-500 transition duration-200">
                Saltar por agora
            </a>
            <x-v5-button type="submit" class="flex-1">
                Finalizar <i class="fas fa-check ml-2"></i>
            </x-v5-button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-guest-layout>
