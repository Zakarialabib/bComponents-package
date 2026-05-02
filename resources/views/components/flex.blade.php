@props([
    'direction' => 'row',
    'wrap' => 'nowrap',
    'justify' => 'start',
    'items' => 'start',
    'gap' => 0,
    'responsive' => null,
])

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div> 