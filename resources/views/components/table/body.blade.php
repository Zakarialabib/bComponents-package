@props([
    'striped' => false,
])

<tbody {{ $attributes->merge(['class' => 'bg-[color:var(--b-color-surface)] divide-y divide-[color:var(--b-color-border)]']) }}>
    {{ $slot }}
</tbody> 
