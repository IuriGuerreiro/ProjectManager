@extends('layouts.app')

@section('title', 'Editar Equipa')

@section('content')
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('teams.list') }}" class="w-10 h-10 rounded-full bg-dark-surface border border-dark-border flex items-center justify-center text-dark-muted hover:text-white transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-2xl font-bold text-white tracking-tight">Editar Equipa</h1>
    </div>

    <div class="space-y-8">
        <x-v5-card title="Informações da Equipa">
            <form action="{{ route('teams.update', ['team_id' => $team->id]) }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-v5-label for="inputTeamDesignation" value="Designação da Equipa" />
                        <x-v5-input id="inputTeamDesignation" name="inputTeamDesignation" value="{{ $team->team_designation }}" />
                    </div>
                    <div>
                        <x-v5-label for="inputTeamfunction" value="Função da Equipa" />
                        <x-v5-input id="inputTeamfunction" name="inputTeamfunction" value="{{ $team->team_function }}" />
                    </div>
                </div>
                <div class="flex justify-end">
                    <x-v5-button type="submit">
                        <i class="fas fa-sync-alt mr-2"></i> Atualizar
                    </x-v5-button>
                </div>
            </form>
        </x-v5-card>

        <!-- Invite Link Section -->
        <x-v5-card title="Link de Convite">
            <div class="space-y-4">
                <p class="text-sm text-dark-muted">
                    <i class="fas fa-share-alt mr-2"></i>
                    Partilhe este link para convidar outros utilizadores para a equipa
                </p>

                @if($team->isInviteValid())
                    <div class="flex gap-2">
                        <input
                            type="text"
                            id="inviteLink"
                            value="{{ route('teams.showInvite', ['token' => $team->invite_token]) }}"
                            readonly
                            class="flex-1 px-4 py-2 bg-dark-bg border border-dark-border rounded-lg text-sm text-white focus:outline-none focus:border-primary-500 font-mono"
                        >
                        <button
                            onclick="copyInviteLink()"
                            class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition duration-200 flex items-center gap-2"
                        >
                            <i class="fas fa-copy"></i>
                            <span id="copyButtonText">Copiar</span>
                        </button>
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <p class="text-xs text-dark-muted">
                            <i class="fas fa-clock mr-1"></i>
                            Expira em: <span class="text-primary-400 font-medium">{{ $team->invite_expires_at->diffForHumans() }}</span>
                            ({{ $team->invite_expires_at->format('d/m/Y H:i') }})
                        </p>
                        <form action="{{ route('teams.regenerateInvite', ['team_id' => $team->id]) }}" method="POST" onsubmit="return confirm('Gerar novo link? O anterior deixará de funcionar.')">
                            @csrf
                            <button type="submit" class="text-xs text-yellow-400 hover:text-yellow-300 transition">
                                <i class="fas fa-sync-alt mr-1"></i> Gerar Novo Link
                            </button>
                        </form>
                    </div>
                @else
                    <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg">
                        <p class="text-sm text-red-400 mb-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            O link de convite expirou
                        </p>
                        <form action="{{ route('teams.regenerateInvite', ['team_id' => $team->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition duration-200 text-sm">
                                <i class="fas fa-sync-alt mr-2"></i> Gerar Novo Link
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </x-v5-card>

        <script>
            function copyInviteLink() {
                const input = document.getElementById('inviteLink');
                const button = document.getElementById('copyButtonText');

                input.select();
                input.setSelectionRange(0, 99999);

                navigator.clipboard.writeText(input.value).then(() => {
                    button.textContent = 'Copiado!';
                    setTimeout(() => {
                        button.textContent = 'Copiar';
                    }, 2000);
                }).catch(() => {
                    document.execCommand('copy');
                    button.textContent = 'Copiado!';
                    setTimeout(() => {
                        button.textContent = 'Copiar';
                    }, 2000);
                });
            }
        </script>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <x-v5-card title="Gerir Membros">
                <x-v5-table :headers="['Nome', 'Email', 'Ações']">
                    @forelse ($users as $user)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4 text-white">{{ $user->user_name ?? "--" }}</td>
                            <td class="px-6 py-4 text-dark-muted">{{ $user->user_email ?? "--" }}</td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('teams.removerUser', ['user_id' => $user->id]) }}"
                                   onclick="return confirm('Remover {{ $user->user_name }} da equipa?')"
                                   class="text-red-400 hover:text-red-300 transition">
                                    <i class="fas fa-user-times"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-dark-muted opacity-50 italic">
                                Nenhum membro nesta equipa. Partilhe o link de convite acima.
                            </td>
                        </tr>
                    @endforelse
                </x-v5-table>
            </x-v5-card>

            <x-v5-card title="Gerir Projetos">
                <x-slot name="action">
                    <x-v5-button size="sm" variant="secondary" onclick="window.location.href='{{ route('teams.addTeamToProject', ['team_id' => $team->id]) }}'">
                        <i class="fas fa-plus mr-2"></i> Adicionar
                    </x-v5-button>
                </x-slot>

                <x-v5-table :headers="['Projeto', 'Estado', 'Ações']">
                    @foreach ($projects as $project)
                        <tr class="hover:bg-dark-border/30 transition duration-200">
                            <td class="px-6 py-4 text-white">{{ $project->project_designation }}</td>
                            <td class="px-6 py-4 text-dark-muted">{{ $project->project_status }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('teams.removeProject', ['Teams_project_id' => $project->id]) }}" class="text-red-400 hover:text-red-300 transition">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </x-v5-table>
            </x-v5-card>
        </div>
    </div>
@endsection
