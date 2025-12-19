@props(['title' => null])

<div {{ $attributes->merge(['class' => 'bg-dark-surface rounded-2xl shadow-lg border border-dark-border overflow-hidden']) }}>
    @if($title)
        <div class="px-6 py-5 border-b border-dark-border flex items-center justify-between">
            <h3 class="font-semibold text-white tracking-tight">{{ $title }}</h3>
            @if(isset($action))
                <div>{{ $action }}</div>
            @endif
        </div>
    @endif
    <div class="p-6">
        {{ $slot }}
    </div>
</div>