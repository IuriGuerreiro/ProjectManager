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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-dark-bg text-dark-text">
        <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
            
            <!-- Sidebar Desktop -->
            <aside class="hidden lg:flex lg:flex-shrink-0">
                <div class="flex flex-col w-64 bg-dark-surface border-r border-dark-border">
                    <div class="flex items-center h-16 flex-shrink-0 px-6 border-b border-dark-border">
                        <div class="w-8 h-8 bg-primary-600 rounded-lg flex items-center justify-center text-white font-bold mr-3 shadow-lg shadow-blue-900/50">P</div>
                        <span class="font-semibold text-lg text-white tracking-wide">ProjectMgr</span>
                    </div>
                    <div class="flex-1 flex flex-col overflow-y-auto py-6">
                        <nav class="flex-1 px-3 space-y-1">
                            <x-v5-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="fas fa-home">
                                Dashboard
                            </x-v5-nav-link>
                            <x-v5-nav-link href="{{ route('projects.list') }}" :active="request()->routeIs('projects.*')" icon="fas fa-layer-group">
                                Projetos
                            </x-v5-nav-link>
                            <x-v5-nav-link href="{{ route('tasks.list') }}" :active="request()->routeIs('tasks.*')" icon="fas fa-check-square">
                                Tarefas
                            </x-v5-nav-link>
                            <x-v5-nav-link href="{{ route('users.list') }}" :active="request()->routeIs('users.*')" icon="fas fa-users">
                                Utilizadores
                            </x-v5-nav-link>
                            <x-v5-nav-link href="{{ route('teams.list') }}" :active="request()->routeIs('teams.*')" icon="fas fa-user-group">
                                Equipas
                            </x-v5-nav-link>
                            <x-v5-nav-link href="{{ route('trainings.list') }}" :active="request()->routeIs('trainings.*')" icon="fas fa-graduation-cap">
                                Formação
                            </x-v5-nav-link>
                            <x-v5-nav-link href="{{ route('formers.list') }}" :active="request()->routeIs('formers.*')" icon="fas fa-chalkboard-teacher">
                                Formadores
                            </x-v5-nav-link>
                        </nav>
                    </div>
                    
                    @auth
                    <div class="flex-shrink-0 flex border-t border-dark-border p-4">
                        <div class="flex-shrink-0 w-full group block">
                            <div class="flex items-center">
                                <div>
                                    <img class="inline-block h-9 w-9 rounded-full border border-dark-border" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=334155&color=cbd5e1" alt="">
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="text-xs font-medium text-dark-muted group-hover:text-primary-400 transition">Sair</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endauth
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex flex-col w-0 flex-1 overflow-hidden">
                <!-- Top Header -->
                <header class="relative z-10 flex-shrink-0 flex h-16 bg-dark-surface/80 backdrop-blur-md border-b border-dark-border">
                    <button type="button" @click="sidebarOpen = true" class="px-4 border-r border-dark-border text-dark-muted focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500 lg:hidden">
                        <span class="sr-only">Open sidebar</span>
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <div class="flex-1 px-8 flex justify-between">
                        <div class="flex-1 flex items-center">
                            <!-- Breadcrumbs Placeholder -->
                            <nav class="flex text-dark-muted text-sm" aria-label="Breadcrumb">
                                <ol class="flex items-center space-x-2">
                                    <li><a href="#" class="hover:text-white transition">App</a></li>
                                    <li><i class="fas fa-chevron-right text-[10px] opacity-30"></i></li>
                                    <li><span class="text-white font-medium">@yield('title', 'Overview')</span></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="ml-4 flex items-center md:ml-6 space-x-4">
                            <button class="bg-dark-bg p-1 rounded-full text-dark-muted hover:text-white focus:outline-none transition">
                                <span class="sr-only">View notifications</span>
                                <i class="far fa-bell"></i>
                            </button>
                        </div>
                    </div>
                </header>

                <main class="flex-1 relative overflow-y-auto focus:outline-none">
                    <div class="py-8">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                            @yield('content')
                        </div>
                    </div>
                </main>
            </div>

            <!-- Mobile Sidebar Overlay -->
            <div x-show="sidebarOpen" class="fixed inset-0 flex z-40 lg:hidden" role="dialog" aria-modal="true" x-cloak>
                <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true" @click="sidebarOpen = false"></div>
                
                <div x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="relative flex-1 flex flex-col max-w-xs w-full bg-dark-surface">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button type="button" @click="sidebarOpen = false" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                            <span class="sr-only">Close sidebar</span>
                            <i class="fas fa-times text-white text-xl"></i>
                        </button>
                    </div>
                    <!-- ... Mobile Nav Content (similar to desktop) ... -->
                </div>
            </div>
        </div>
    </body>
</html>
