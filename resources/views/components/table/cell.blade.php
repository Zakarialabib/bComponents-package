@props([
    'align' => 'left'
])

<td {{ $attributes->merge(['class' => 'px-6 py-4 whitespace-nowrap text-sm text-[color:var(--b-color-text-muted)] text-' . $align]) }}>
    {{ $slot }}
</td> 
