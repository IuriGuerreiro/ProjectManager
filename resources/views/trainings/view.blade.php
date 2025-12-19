@extends('layouts.app')

@section('title', 'Detalhes da Formação')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('trainings.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">{{ $training->trainings_designation }}</h1>
                <p class="text-dark-muted text-sm mt-1">Código: <span class="text-primary-400 font-mono">{{ $training->trainings_code }}</span></p>
            </div>
        </div>
        <div class="flex gap-3">
             <x-v5-button variant="secondary" onclick="window.location.href='{{ route('trainings.edit', ['training_id' => $training->id]) }}'">
                <i class="fas fa-edit mr-2"></i> Editar
            </x-v5-button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Tables -->
        <div class="lg:col-span-2 space-y-8">
            <x-v5-card title="Participantes (Utilizadores)">
                <x-v5-table :headers="['Nome', 'Email']">
                    @forelse ($users as $user)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4">
                                <a href="{{ route('users.view', ['id'=>$user->id]) }}" class="font-medium text-white hover:text-primary-400 transition">
                                    {{ $user->name ?? "--" }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-dark-muted">{{ $user->email ?? "--" }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                                Nenhum utilizador inscrito nesta formação.
                            </td>
                        </tr>
                    @endforelse
                </x-v5-table>
            </x-v5-card>

            <x-v5-card title="Formadores">
                <x-v5-table :headers="['Nome', 'Email']">
                    @forelse ($formers as $former)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4 font-medium text-white">{{ $former->name ?? "--" }}</td>
                            <td class="px-6 py-4 text-dark-muted">{{ $former->email ?? "--" }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                                Nenhum formador atribuído.
                            </td>
                        </tr>
                    @endforelse
                </x-v5-table>
            </x-v5-card>
        </div>

        <!-- Right Column: Info & Actions -->
        <div class="space-y-8">
            <x-v5-card title="Informação">
                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-bold text-dark-muted uppercase tracking-wider">Estado</span>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-500/10 text-primary-400 border border-primary-500/20">
                                {{ $training->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-dark-border">
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div class="bg-dark-bg p-3 rounded-xl border border-dark-border">
                                <div class="text-xl font-bold text-white">{{ count($users) }}</div>
                                <div class="text-[10px] text-dark-muted uppercase tracking-wide">Alunos</div>
                            </div>
                            <div class="bg-dark-bg p-3 rounded-xl border border-dark-border">
                                <div class="text-xl font-bold text-white">{{ count($formers) }}</div>
                                <div class="text-[10px] text-dark-muted uppercase tracking-wide">Formadores</div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-v5-card>

            <x-v5-card title="Ações">
                <div class="flex flex-col gap-2">
                    <x-v5-button variant="secondary" size="sm" class="justify-start" onclick="window.location.href='{{ route('trainings.addUsers', ['training_id' => $training->id]) }}'">
                        <i class="fas fa-plus mr-2"></i> Adicionar Participantes
                    </x-v5-button>
                    <x-v5-button variant="danger" size="sm" class="justify-start">
                        <i class="fas fa-trash mr-2"></i> Remover Formação
                    </x-v5-button>
                </div>
            </x-v5-card>
        </div>
    </div>
@endsection
