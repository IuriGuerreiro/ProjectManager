@extends('layouts.app')

@section('title', 'Criar Utilizador')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('users.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Novo Colaborador</h1>
    </div>

    <div class="max-w-2xl">
        <x-v5-card>
            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <x-v5-label for="inputUserName" value="Nome Completo" />
                    <x-v5-input id="inputUserName" name="inputUserName" placeholder="Ex: João Silva" required />
                </div>

                <div>
                    <x-v5-label for="inputUserEmail" value="Email" />
                    <x-v5-input id="inputUserEmail" name="inputUserEmail" type="email" placeholder="joao@exemplo.com" required />
                </div>

                <div>
                    <x-v5-label for="inputUserPassword" value="Palavra-passe" />
                    <x-v5-input id="inputUserPassword" name="inputUserPassword" type="password" placeholder="••••••••" required />
                </div>

                <div class="flex justify-end pt-4">
                    <x-v5-button type="submit">
                        <i class="fas fa-user-plus mr-2"></i> Registar Colaborador
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>
    </div>
@endsection
