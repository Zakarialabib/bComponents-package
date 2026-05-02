@props([
    'selected' => false,
])

<tr {{ $attributes->merge(['class' => $selected ? 'bg-[color:var(--b-color-surface-muted)]' : 'hover:bg-[color:var(--b-color-surface-muted)]']) }}>
    {{ $slot }}
</tr> 
