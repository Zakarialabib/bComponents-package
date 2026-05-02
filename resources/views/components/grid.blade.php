@props([
    'cols' => 12,
    'gap' => 4,
    'responsive' => null,
    'autoFit' => false,
    'minWidth' => null,
])

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div> 