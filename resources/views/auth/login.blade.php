<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-v5-label for="email" value="Email" />
            <x-v5-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="exemplo@dominio.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-v5-label for="password" value="Palavra-passe" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-primary-500 hover:text-primary-400 transition mb-2" href="{{ route('password.request') }}">
                        Esqueceste-te da senha?
                    </a>
                @endif
            </div>
            <x-v5-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="rounded bg-dark-bg border-dark-border text-primary-600 focus:ring-primary-500 focus:ring-offset-dark-surface transition" name="remember">
            <label for="remember_me" class="ml-2 text-sm text-dark-muted">Lembrar-me</label>
        </div>

        <div class="pt-2">
            <x-v5-button class="w-full">
                Entrar
            </x-v5-button>
        </div>

        @if (Route::has('register'))
            <div class="text-center">
                <a class="text-sm text-dark-muted hover:text-primary-400 transition" href="{{ route('register') }}">
                    Não tens uma conta? <span class="text-primary-500 font-medium">Registar</span>
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>
