@props([
    'color' => 'primary',
    'size' => 'md',
    'variant' => 'solid',
    'icon' => null,
    'iconPosition' => 'left',
    'isIconOnly' => false,
    'isDismissible' => false,
    'isCounter' => false,
    'wireClick' => null,
    'title' => null,
])


<div {{ $attributes }}>
    
    @if ($icon && $iconPosition === 'left' && !$isIconOnly)
        <i class="{{ $icon }} {{ $slot->isEmpty() ? '' : 'mr-2' }}"></i>
    @endif

    @if ($variant === 'dot')
        <span class="w-2 h-2 rounded-full mr-2 bg-current"></span>
    @endif

    @unless ($isIconOnly)
        {{ $slot }}
    @else
        <i class="{{ $icon }}"></i>
        <span class="sr-only">{{ $slot }}</span>
    @endunless

    @if ($icon && $iconPosition === 'right' && !$isIconOnly)
        <i class="{{ $icon }} {{ $slot->isEmpty() ? '' : 'ml-2' }}"></i>
    @endif

    @if ($isDismissible)
        <button type="button"
            class="absolute right-1 top-1/2 transform -translate-y-1/2 text-current opacity-60 hover:opacity-100 focus:outline-none"
            aria-label="Dismiss" x-on:click="$el.parentNode.remove()">
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    @endif
</div>
