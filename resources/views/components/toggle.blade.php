@props([
    'name',
    'value' => '',
    'label' => null,
    'checked' => false,
    'disabled' => false,
    'required' => false,
    'size' => 'md',
    'color' => 'primary',
    'helper' => false,
    'helperText' => null,
    'icons' => false,
])

<div class="flex items-start">
    <div class="flex items-center h-5">
        <button
            type="button"
            role="switch"
            aria-checked="{{ $checked ? 'true' : 'false' }}"
            @disabled($disabled)
            x-data="{ checked: @js($checked) }"
            x-modelable="checked"
            x-on:click="if (!$el.disabled) checked = !checked"
            :class="checked ? 'bg-[color:var(--b-color-primary)]' : 'bg-black/10'"
            {{ $attributes->merge(['class' => $classes]) }}
        >
            <span class="sr-only">{{ $label }}</span>
            <span
                aria-hidden="true"
                class="{{ $buttonClasses }}"
                :class="checked ? '{{ $translateClass }}' : 'translate-x-0'"
            >
                @if($icons)
                    <span class="flex items-center justify-center h-full w-full" x-show="!checked">
                        <svg class="h-2 w-2 text-gray-400" fill="none" viewBox="0 0 12 12">
                            <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="flex items-center justify-center h-full w-full" x-show="checked">
                        <svg class="h-2 w-2 text-[color:var(--b-color-primary)]" fill="currentColor" viewBox="0 0 12 12">
                            <path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"/>
                        </svg>
                    </span>
                @endif
            </span>
        </button>
        <input
            type="hidden"
            name="{{ $name }}"
            x-bind:value="checked ? @js($value) : ''"
            @required($required)
        >
    </div>
    
    @if($label)
        <div class="ml-3 text-sm">
            <label for="{{ $name }}" class="font-medium text-[color:var(--b-color-text)] {{ $disabled ? 'opacity-50' : '' }}">
                {{ $label }}
            </label>
            @if($helper && $helperText)
                <p class="opacity-75">{{ $helperText }}</p>
            @endif
        </div>
    @endif
</div> 
