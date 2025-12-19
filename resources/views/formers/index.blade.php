@extends('layouts.app')

@section('title', 'Lista de Formadores')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Formadores</h1>
            <p class="text-dark-muted text-sm mt-1">Gerencie os instrutores e suas especializações.</p>
        </div>
        <x-v5-button onclick="window.location.href='{{ route('formers.create') }}'">
            <i class="fas fa-plus mr-2"></i> Novo Formador
        </x-v5-button>
    </div>

    <x-v5-card>
        <x-v5-table :headers="['Nome', 'Email', 'Formações', 'Ações']">
            @foreach ($formers as $former)
                <tr class="hover:bg-dark-border/30 transition duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-purple-500/10 text-purple-400 flex items-center justify-center font-bold text-xs mr-3 border border-purple-500/20">
                                {{ strtoupper(substr($former->name, 0, 1)) }}
                            </div>
                            <div class="font-medium text-white">{{ $former->name ?? "--" }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-dark-muted text-sm">{{ $former->email ?? "--" }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs bg-dark-bg px-2 py-1 rounded border border-dark-border text-dark-muted">
                            {{ $former->add ?? '0' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('formers.view', ['former_id' => $former->id]) }}" class="text-dark-muted hover:text-primary-400 transition">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('formers.edit', ['former_id' => $former->id]) }}" class="text-dark-muted hover:text-yellow-400 transition">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('formers.delete', ['former_id' => $former->id]) }}" onclick="return confirm('Tem a certeza?')" class="text-dark-muted hover:text-red-400 transition">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-v5-table>
    </x-v5-card>
@endsection
