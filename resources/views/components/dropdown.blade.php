@props([
    'open' => false,
    'widthClass' => 'w-56',
    'alignClass' => 'left-0',
])

<div
    x-data="{ open: @js($open) }"
    x-on:keydown.escape.window="open = false"
    class="relative inline-block text-left"
>
    <div x-on:click="open = !open">
        {{ $trigger }}
    </div>

    <div
        x-cloak
        x-show="open"
        x-on:click.outside="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute {{ $alignClass }} mt-2 {{ $widthClass }} origin-top rounded-[var(--b-radius-md)] border border-[color:var(--b-color-border)] bg-[color:var(--b-color-surface)] text-[color:var(--b-color-text)] shadow-[var(--b-shadow-sm)] z-50"
    >
        <div class="py-1">
            {{ $content }}
        </div>
    </div>
</div>

