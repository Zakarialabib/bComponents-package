@props([
    'open' => false,
    'widthClass' => 'w-56',
    'alignClass' => 'left-0',
    'name' => null,
])

<div
    x-data="bDropdown({ initialOpen: @js($open), name: @js($name) })"
    x-on:keydown.escape.window="close()"
    x-on:open-dropdown.window="$event.detail == name ? openNamed($event.detail) : null"
    x-on:close-dropdown.window="$event.detail == name ? closeNamed($event.detail) : null"
    class="relative inline-block text-left"
>
    <div
        x-on:click="toggle()"
        role="button"
        tabindex="0"
        aria-haspopup="menu"
        :aria-expanded="open"
        x-on:keydown.enter.prevent="toggle()"
        x-on:keydown.space.prevent="toggle()"
    >
        {{ $trigger }}
    </div>

    <div
        x-cloak
        x-show="open"
        x-on:click.outside="close()"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute {{ $alignClass }} mt-2 {{ $widthClass }} origin-top rounded-[var(--b-radius-md)] border border-[color:var(--b-color-border)] bg-[color:var(--b-color-surface)] text-[color:var(--b-color-text)] shadow-[var(--b-shadow-sm)] z-50"
        role="menu"
    >
        <div class="py-1">
            {{ $content }}
        </div>
    </div>
</div>
