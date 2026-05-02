@props([
    'type' => 'horizontal',
    'label' => null,
    'labelPosition' => 'center',
    'color' => 'gray',
    'thickness' => 'normal',
])

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($label && $type === 'horizontal')
        <span class="absolute -top-3.5 bg-white px-4 text-sm text-{{ $color }}-500 {{ $labelPositionClasses }}">
            {{ $label }}
        </span>
    @endif
</div> 