@props([
    'title' => '',
    'id' => null,
    'isOpen' => false,
    'icon' => null,
    'iconPosition' => 'right',
    'isMultiple' => false,
    'shouldRemember' => false,
    'animationDuration' => 300,
    'headingLevel' => 3,
    'animation' => 'fade',
    'size' => 'md',
])

@php
    // Generate a unique ID if none is provided
    $id = $id ?? uniqid('accordion-');
@endphp

<div x-data="{
    open: @js($isOpen),
    multiple: @js($isMultiple),
    remember: @js($shouldRemember),
    animationDuration: @js($animationDuration),
    init() {
        if (this.remember) {
            const key = 'accordion-{{ $id }}';
            this.open = localStorage.getItem(key) === 'true';
        }
        this.$watch('open', value => {
            if (!this.multiple) {
                this.closeOthers();
            }
            if (this.remember) {
                const key = 'accordion-{{ $id }}';
                localStorage.setItem(key, value);
            }
        });
    },
    closeOthers() {
        document.querySelectorAll('[data-accordion]').forEach(accordion => {
            if (accordion.id !== '{{ $id }}') {
                accordion.__x.$data.open = false;
            }
        });
    }
}" id="{{ $id }}" data-accordion
    {{ $attributes->merge(['class' => trim(($classes ?? '') . ' ' . ($size ?? ''))]) }} role="region"
    aria-labelledby="accordion-header-{{ $id }}">
    <div class="flex flex-col w-full">
        <div class="{{ $headerClasses ?? '' }}" @click="open = !open" @keydown.space.prevent="open = !open"
            @keydown.enter.prevent="open = !open" id="accordion-header-{{ $id }}" :aria-expanded="open"
            role="button" tabindex="0">
            @if ($iconPosition === 'left' && $icon)
                <i class="fas fa-{{ $icon }} {{ $iconClasses ?? '' }} mr-2" :class="{ 'rotate-180': open }"></i>
            @endif

            <span class="{{ $titleClasses ?? '' }}">
                {{ $title }}
            </span>

            @if ($iconPosition === 'right')
                @if ($icon)
                    <i class="fas fa-{{ $icon }} {{ $iconClasses ?? '' }} ml-2"
                        :class="{ 'rotate-180': open }"></i>
                @else
                    <svg class="{{ $iconClasses ?? '' }} ml-2" :class="{ 'rotate-180': open }" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            @endif
        </div>

        <div x-show="open" x-transition:enter="{{ $animation }} duration-{{ $animationDuration }}"
            x-transition:enter-start="opacity-0 transform -translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="{{ $animation }} duration-{{ $animationDuration }}"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-2" class="{{ $contentClasses ?? '' }} bg-[color:var(--b-color-surface)]"
            role="region" :aria-hidden="!open">
            <div class="flex flex-col">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
