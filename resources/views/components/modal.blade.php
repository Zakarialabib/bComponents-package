@props([
    'name',
    'show' => false,
    'maxWidth' => '2xl',
    'centered' => false,
    'scrollable' => false,
    'static' => false,
    'title' => null
])

<div
    x-data="bOverlay({ initialOpen: @js($show), static: @js($static) })"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? open() : null"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? close() : null"
    x-on:close.stop="close()"
    x-on:keydown.escape.window="close()"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50 {{ $centered ? 'flex items-center justify-center min-h-screen' : '' }}"
    style="display: {{ $show ? 'block' : 'none' }};"
>
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="{{ $static ? '' : 'show = false' }}"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div
        x-show="show"
        class="mb-6 bg-[color:var(--b-color-surface)] text-[color:var(--b-color-text)] rounded-[var(--b-radius-md)] overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidthClass }} sm:mx-auto {{ $scrollable ? 'overflow-y-auto max-h-[80vh]' : '' }}"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        @if ($title)
            <div class="px-6 py-4 border-b border-[color:var(--b-color-border)]">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium">
                        {{ $title }}
                    </h3>
                    
                    @unless ($static)
                        <button 
                            type="button" 
                            class="text-[color:var(--b-color-text)] opacity-70 hover:opacity-100"
                            x-on:click="show = false"
                        >
                            <span class="sr-only">Close</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endunless
                </div>
            </div>
        @endif
        
        <div class="px-6 py-4">
            {{ $slot }}
        </div>
        
        @if (isset($footer))
            <div class="px-6 py-4 border-t border-[color:var(--b-color-border)] flex justify-end space-x-3">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
