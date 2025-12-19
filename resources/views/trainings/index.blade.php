@extends('layouts.app')

@section('title', 'Lista de Formações')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Formações</h1>
            <p class="text-dark-muted text-sm mt-1">Gerencie os programas de formação e capacitação.</p>
        </div>
        <x-v5-button onclick="window.location.href='{{ route('trainings.create') }}'">
            <i class="fas fa-plus mr-2"></i> Nova Formação
        </x-v5-button>
    </div>

    <x-v5-card>
        <x-v5-table :headers="['Código', 'Designação', 'Estado', 'Participantes', 'Ações']">
            @foreach ($trainings as $training)
                <tr class="hover:bg-dark-border/30 transition duration-200">
                    <td class="px-6 py-4">
                        <span class="font-mono text-xs text-primary-400 bg-primary-500/10 px-2 py-1 rounded border border-primary-500/20">
                            {{ $training['trainings_code'] ?? "--" }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-white">{{ $training['trainings_designation'] ?? "--" }}</td>
                    <td class="px-6 py-4">
                        @php
                            $status = $training['status'] ?? '--';
                            $statusClass = match($status) {
                                'Concluído' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                'Em Curso' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                'Pendente' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                default => 'bg-dark-bg text-dark-muted border-dark-border'
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $statusClass }}">
                            {{ $status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center text-dark-muted">
                            <i class="fas fa-user-graduate mr-2 opacity-50"></i>
                            {{ $training['participants'] ?? '0' }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('trainings.view', ['training_id' => $training['id']]) }}" class="text-dark-muted hover:text-primary-400 transition">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('trainings.edit', ['training_id' => $training['id']]) }}" class="text-dark-muted hover:text-yellow-400 transition">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('trainings.delete', ['training_id' => $training['id']]) }}" onclick="return confirm('Tem a certeza?')" class="text-dark-muted hover:text-red-400 transition">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-v5-table>
    </x-v5-card>
@endsection
