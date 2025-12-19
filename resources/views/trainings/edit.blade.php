@extends('layouts.app')

@section('title', 'Gerir Formação')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('trainings.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Gerir Formação</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <x-v5-card title="Utilizadores Inscritos">
                <x-slot name="action">
                    <x-v5-button size="sm" variant="secondary" onclick="window.location.href='{{ route('trainings.addUsers', ['training_id' => $training->id]) }}'">
                        <i class="fas fa-plus mr-2"></i> Adicionar
                    </x-v5-button>
                </x-slot>
                
                <x-v5-table :headers="['Nome', 'Email']">
                    @forelse ($users as $user)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4 text-white">{{ $user->name ?? "--" }}</td>
                            <td class="px-6 py-4 text-dark-muted">{{ $user->email ?? "--" }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">Nenhum utilizador.</td>
                        </tr>
                    @endforelse
                </x-v5-table>
            </x-v5-card>

            <x-v5-card title="Formadores Atribuídos">
                <x-v5-table :headers="['Nome', 'Email']">
                    @forelse ($formers as $former)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4 text-white">{{ $former->name ?? "--" }}</td>
                            <td class="px-6 py-4 text-dark-muted">{{ $former->email ?? "--" }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">Nenhum formador.</td>
                        </tr>
                    @endforelse
                </x-v5-table>
            </x-v5-card>
        </div>

        <div class="space-y-8">
            <x-v5-card title="Detalhes da Formação">
                <div class="space-y-4">
                    <div>
                        <x-v5-label value="Código" />
                        <span class="form-control bg-dark-bg border-dark-border text-primary-400 font-mono">{{ $training->trainings_code }}</span>
                    </div>
                    <div>
                        <x-v5-label value="Designação" />
                        <span class="form-control bg-dark-bg border-dark-border text-white">{{ $training->trainings_designation }}</span>
                    </div>
                    <div>
                        <x-v5-label value="Estado" />
                        <span class="form-control bg-dark-bg border-dark-border text-white">{{ $training->status }}</span>
                    </div>
                </div>
            </x-v5-card>
        </div>
    </div>
@endsection
