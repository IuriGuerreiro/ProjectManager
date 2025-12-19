@props(['headers'])

<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead class="bg-dark-bg/50 text-dark-muted text-xs uppercase font-medium">
            <tr>
                @foreach($headers as $header)
                    <th class="px-6 py-3 font-semibold tracking-wider">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-dark-border">
            {{ $slot }}
        </tbody>
    </table>
</div>