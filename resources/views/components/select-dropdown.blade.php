@props([
    'name' => '',
    'placeholder' => null,
    'options' => [],
    'value' => null,
    'selectedLabel' => null,
    'required' => false,
    'disabled' => false,
])

<div
    x-data="{
        open: false,
        value: @js($value),
        label: @js($selectedLabel),
        choose(v, l) { this.value = v; this.label = l; this.open = false; },
    }"
    class="relative"
>
    <input type="hidden" name="{{ $name }}" x-bind:value="value" @required($required) />

    <button
        type="button"
        @disabled($disabled)
        x-on:click="open = !open"
        class="w-full inline-flex items-center justify-between rounded-[var(--b-radius-md)] border border-[color:var(--b-color-border)] bg-[color:var(--b-color-surface)] px-3.5 py-2.5 text-sm text-[color:var(--b-color-text)] shadow-[var(--b-shadow-sm)]"
    >
        <span class="truncate" x-text="label || @js($placeholder ?? 'Select...')"></span>
        <svg class="h-4 w-4 opacity-70" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" />
        </svg>
    </button>

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
        class="absolute left-0 right-0 mt-2 max-h-60 overflow-auto rounded-[var(--b-radius-md)] border border-[color:var(--b-color-border)] bg-[color:var(--b-color-surface)] text-[color:var(--b-color-text)] shadow-[var(--b-shadow-sm)] z-50"
    >
        <div class="py-1">
            @foreach ($options as $option)
                @php
                    $optionValue = is_array($option) ? ($option['value'] ?? null) : null;
                    $optionLabel = is_array($option) ? ($option['label'] ?? '') : (string) $option;
                @endphp
                <button
                    type="button"
                    class="w-full text-left px-3 py-2 text-sm hover:bg-black/5"
                    x-on:click="choose(@js($optionValue), @js($optionLabel))"
                >
                    {{ $optionLabel }}
                </button>
            @endforeach
        </div>
    </div>
</div>

