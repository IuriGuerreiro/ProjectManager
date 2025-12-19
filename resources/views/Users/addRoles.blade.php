@extends('layouts.app')

@section('title', 'Atribuir Funções')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('users.view', ['id' => $user->id]) }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Atribuir Funções</h1>
    </div>

    <div class="max-w-2xl">
        <x-v5-card title="Colaborador: {{ $user->name }}">
            <form action="{{ route('users.storeRole', ['user_id' => $user->id]) }}" method="POST" class="space-y-6">
                @csrf 
                <div>
                    <x-v5-label for="inputRoleId" value="Selecionar Função" />
                    <select id="inputRoleId" name="inputRoleId" class="block w-full px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all duration-200">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->role_designation }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end pt-4">
                    <x-v5-button type="submit">
                        <i class="fas fa-plus mr-2"></i> Adicionar Função
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>
    </div>
@endsection
