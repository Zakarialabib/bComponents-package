@props([
    'default' => null,
])

<div
    x-data="{ active: @js($default) }"
    class="flex flex-wrap items-start gap-x-2 gap-y-2"
>
    {{ $slot }}
</div>

