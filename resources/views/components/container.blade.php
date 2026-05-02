@props([
    'maxWidth' => '7xl',
    'padding' => 'md',
    'centered' => true,
])

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div> 