<x-guest-layout>
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-white mb-2">Bem-vindo ao Sistema</h1>
        <p class="text-dark-muted text-sm">Configure a sua conta em 2 passos</p>

        <div class="flex justify-center items-center gap-3 mt-6">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-primary-500 text-white flex items-center justify-center font-bold text-sm">1</div>
                <span class="ml-2 text-white text-sm font-medium">Info</span>
            </div>
            <div class="w-8 h-0.5 bg-dark-border"></div>
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-dark-surface border border-dark-border text-dark-muted flex items-center justify-center font-bold text-sm">2</div>
                <span class="ml-2 text-dark-muted text-sm">Equipa</span>
            </div>
        </div>
    </div>

    <form action="{{ route('onboarding.processStep1') }}" method="POST" class="space-y-6">
        @csrf

        <div class="text-center mb-6">
            <h2 class="text-xl font-semibold text-white mb-2">Conte-nos mais sobre si</h2>
            <p class="text-sm text-dark-muted">Estas informações ajudam-nos a personalizar a sua experiência</p>
        </div>

        <div>
            <x-v5-label for="organization_name" value="Nome da Organização (Opcional)" />
            <x-v5-input
                id="organization_name"
                name="organization_name"
                type="text"
                placeholder="Ex: Empresa ABC, Departamento XYZ"
                value="{{ old('organization_name') }}"
            />
            @error('organization_name')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <x-v5-label for="position" value="Cargo/Função (Opcional)" />
            <x-v5-input
                id="position"
                name="position"
                type="text"
                placeholder="Ex: Gestor de Projeto, Developer, Designer"
                value="{{ old('position') }}"
            />
            @error('position')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col sm:flex-row gap-4 pt-6">
            <a href="{{ route('onboarding.skip') }}" class="flex-1 text-center px-6 py-3 bg-dark-surface border border-dark-border rounded-lg text-dark-muted hover:text-white hover:border-primary-500 transition duration-200">
                Saltar por agora
            </a>
            <x-v5-button type="submit" class="flex-1">
                Continuar <i class="fas fa-arrow-right ml-2"></i>
            </x-v5-button>
        </div>
    </form>
</x-guest-layout>
