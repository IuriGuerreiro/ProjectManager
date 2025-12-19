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