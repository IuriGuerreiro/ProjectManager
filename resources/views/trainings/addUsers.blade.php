@extends('layouts.app')

@section('title', 'Adicionar Participantes')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('trainings.view', ['training_id' => $training->id]) }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Inscrever Utilizadores</h1>
    </div>

    <div class="max-w-4xl">
        <x-v5-card title="Inscrição: {{ $training->trainings_designation }}">
            <form action="{{ route('trainings.storeUsers', ['training_id' => $training->id]) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <x-v5-label value="Selecione os utilizadores para inscrever" />
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 bg-dark-bg rounded-xl border border-dark-border max-h-96 overflow-y-auto">
                        @forelse($users as $user)
                            <label class="flex items-center space-x-3 p-3 rounded-lg border border-dark-border hover:bg-dark-surface transition cursor-pointer group">
                                <input type="checkbox" name="inputTrainingUser[]" value="{{ $user->id }}" class="rounded bg-dark-bg border-dark-border text-primary-600 focus:ring-primary-500 focus:ring-offset-dark-surface transition">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-white group-hover:text-primary-400 transition">{{ $user->name }}</span>
                                    <span class="text-xs text-dark-muted">{{ $user->email }}</span>
                                </div>
                            </label>
                        @empty
                            <div class="col-span-2 text-center py-8">
                                <i class="fas fa-exclamation-circle text-4xl text-dark-muted mb-4"></i>
                                <p class="text-dark-muted mb-2">Nenhum utilizador disponível</p>
                                <p class="text-sm text-dark-muted">Certifique-se de que:</p>
                                <ul class="text-sm text-dark-muted mt-2 space-y-1">
                                    <li>• A formação tem equipas atribuídas</li>
                                    <li>• Existem utilizadores nessas equipas</li>
                                    <li>• Os utilizadores ainda não estão inscritos</li>
                                </ul>
                                <a href="{{ route('trainings.edit', ['training_id' => $training->id]) }}" class="inline-block mt-4 px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                                    <i class="fas fa-edit mr-2"></i>Editar Formação
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <x-v5-button type="submit">
                        <i class="fas fa-user-plus mr-2"></i> Confirmar Inscrições
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>
    </div>
@endsection
