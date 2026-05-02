@props([
    'selected' => false,
])

<tr {{ $attributes->merge(['class' => $selected ? 'bg-gray-50' : 'hover:bg-gray-50']) }}>
    {{ $slot }}
</tr> 