<x-guest-layout>
    <form method="POST" action="{{ route("register") }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-v5-label for="name" value="Nome Completo" />
            <x-v5-input id="name" type="text" name="name" :value="old(\"name\")" required autofocus autocomplete="name" placeholder="Como devemos chamar-te?" />
            <x-input-error :messages="$errors->get(\"name\")" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-v5-label for="email" value="Endereço de Email" />
            <x-v5-input id="email" type="email" name="email" :value="old(\"email\")" required autocomplete="username" placeholder="exemplo@dominio.com" />
            <x-input-error :messages="$errors->get(\"email\")" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-v5-label for="password" value="Palavra-passe" />
            <x-v5-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get(\"password\")" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-v5-label for="password_confirmation" value="Confirmar Palavra-passe" />
            <x-v5-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get(\"password_confirmation\")" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-v5-button class="w-full">
                Criar Conta
            </x-v5-button>
        </div>

        <div class="text-center">
            <a class="text-sm text-dark-muted hover:text-primary-400 transition" href="{{ route(\"login\") }}">
                Já tens uma conta? <span class="text-primary-500 font-medium">Entrar</span>
            </a>
        </div>
    </form>
</x-guest-layout>
