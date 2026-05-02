@props([
    'size' => 4,
    'type' => 'vertical',
    'responsive' => null,
])

<div {{ $attributes->merge(['class' => $classes]) }}></div> 