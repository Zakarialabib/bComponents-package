@props([
    'default' => null,
])

<div
    x-data="bTabs({ initial: @js($default) })"
    class="flex flex-wrap items-start gap-x-2 gap-y-2"
>
    {{ $slot }}
</div>
