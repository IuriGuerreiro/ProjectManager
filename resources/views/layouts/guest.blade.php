<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SGP') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-dark-bg text-dark-text min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-md">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-600 rounded-2xl shadow-lg shadow-blue-900/50 mb-4">
                    <span class="text-2xl font-bold text-white">P</span>
                </div>
                <h1 class="text-3xl font-bold text-white tracking-tight">ProjectMgr</h1>
                <p class="text-dark-muted mt-2 text-sm">Sistema de Gestão de Projetos e Formações</p>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-green-500/10 border border-green-500/20 rounded-lg">
                    <p class="text-sm text-green-400 text-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            @if(session('error'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
                    <p class="text-sm text-red-400 text-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            @if(session('info'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="mb-6 p-4 bg-blue-500/10 border border-blue-500/20 rounded-lg">
                    <p class="text-sm text-blue-400 text-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        {{ session('info') }}
                    </p>
                </div>
            @endif

            <x-v5-card>
                {{ $slot }}
            </x-v5-card>

            <div class="text-center mt-8">
                <p class="text-xs text-dark-muted">
                    &copy; {{ date('Y') }} SGP. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </body>
</html>