@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-dark-muted mb-2']) }}>
    {{ $value ?? $slot }}
</label>