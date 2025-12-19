@extends('layouts.app')

@section('title', 'Detalhes do Formador')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('formers.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white tracking-tight">{{ $former->name }}</h1>
                <p class="text-dark-muted text-sm mt-1">{{ $former->email }}</p>
            </div>
        </div>
        <div class="flex gap-3">
             <x-v5-button variant="secondary" onclick="window.location.href='{{ route('formers.edit', ['former_id' => $former->id]) }}'">
                <i class="fas fa-edit mr-2"></i> Editar
            </x-v5-button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <x-v5-card title="Formações Ministradas">
                <x-v5-table :headers="['Código', 'Designação', 'Estado']">
                    @forelse ($trainings as $training)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4 font-mono text-xs text-primary-400">{{ $training->trainings_code ?? "--" }}</td>
                            <td class="px-6 py-4 font-medium text-white">{{ $training->trainings_designation ?? "--" }}</td>
                            <td class="px-6 py-4">
                                <span class="text-xs bg-dark-bg px-2 py-1 rounded border border-dark-border text-dark-muted">N/A</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                                Este formador ainda não participou em nenhuma formação.
                            </td>
                        </tr>
                    @endforelse
                </x-v5-table>
            </x-v5-card>
        </div>

        <div class="space-y-8">
            <x-v5-card title="Estatísticas">
                <div class="grid grid-cols-1 gap-4">
                    <div class="bg-dark-bg p-4 rounded-xl border border-dark-border">
                        <div class="text-2xl font-bold text-white">{{ count($trainings) }}</div>
                        <div class="text-xs text-dark-muted uppercase tracking-wide mt-1">Total de Formações</div>
                    </div>
                </div>
            </x-v5-card>
        </div>
    </div>
@endsection
