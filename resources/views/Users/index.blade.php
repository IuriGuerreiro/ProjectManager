@extends("layouts.app")

@section("title", "Gestão de Utilizadores")

@section("content")
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white tracking-tight">Utilizadores</h1>
            <p class="text-dark-muted text-sm mt-1">Gerencie os colaboradores e suas permissões no sistema.</p>
        </div>
        <x-v5-button onclick="window.location.href='{{ route('users.create') }}'">
            <i class="fas fa-user-plus mr-2"></i> Adicionar Utilizador
        </x-v5-button>
    </div>

    <x-v5-card>
        <x-v5-table :headers="['Nome', 'Email', 'Projetos', 'Ações']">
            @foreach ($users as $user)
                <tr class="hover:bg-dark-border/30 transition duration-200">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <img class="h-8 w-8 rounded-full border border-dark-border mr-3" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=334155&color=cbd5e1" alt="">
                            <div class="font-medium text-white">{{ $user->name ?? "--" }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-dark-muted text-sm">{{ $user->email ?? "--" }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs bg-dark-bg px-2 py-1 rounded border border-dark-border text-dark-muted">N/A</span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('users.view', ['id' => $user->id]) }}" class="text-dark-muted hover:text-primary-400 transition">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="text-dark-muted hover:text-yellow-400 transition">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('users.delete', ['id' => $user->id]) }}" onclick="return confirm('Tem a certeza?')" class="text-dark-muted hover:text-red-400 transition">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </x-v5-table>
    </x-v5-card>
@endsection