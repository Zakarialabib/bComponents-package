@props([
    'sticky' => false,
])

<thead {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</thead> 