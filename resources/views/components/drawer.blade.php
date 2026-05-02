@props([
    'name',
    'show' => false,
    'position' => 'right',
    'width' => 'md',
    'static' => false,
    'title' => null
])

<div
    x-data="{
        show: @js($show),
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:open-drawer.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close-drawer.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="{{ $static ? '' : 'show = false' }}"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    class="fixed inset-0 overflow-hidden z-50"
    style="display: {{ $show ? 'block' : 'none' }};"
>
    <div
        x-show="show"
        class="absolute inset-0 overflow-hidden"
    >
        <!-- Background overlay -->
        <div 
            x-show="show"
            x-transition:enter="ease-in-out duration-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-500"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
            x-on:click="{{ $static ? '' : 'show = false' }}"
        ></div>

        <div class="fixed inset-y-0 {{ $position === 'right' ? 'right-0 pl-10' : 'left-0 pr-10' }} {{ $position === 'top' ? 'top-0 pb-10' : ($position === 'bottom' ? 'bottom-0 pt-10' : '') }} max-w-full flex">
            <div 
                x-show="show"
                x-transition:enter="transform transition ease-in-out duration-500"
                x-transition:enter-start="{{ $positionClass }}"
                x-transition:enter-end="{{ $transitionClass }}"
                x-transition:leave="transform transition ease-in-out duration-500"
                x-transition:leave-start="{{ $transitionClass }}"
                x-transition:leave-end="{{ $positionClass }}"
                class="relative {{ $widthClass }} {{ $isVertical ? 'h-full' : 'w-full' }}"
            >
                <!-- Drawer panel -->
                <div class="h-full flex flex-col bg-white shadow-xl overflow-y-auto">
                    @if ($title)
                        <div class="px-4 py-6 sm:px-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium text-gray-900" id="drawer-title">{{ $title }}</h2>
                                <button 
                                    type="button" 
                                    class="rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    x-on:click="show = false"
                                >
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    <div class="relative flex-1 px-4 py-6 sm:px-6">
                        {{ $slot }}
                    </div>

                    @if (isset($footer))
                        <div class="flex-shrink-0 px-4 py-4 flex justify-end border-t border-gray-200">
                            {{ $footer }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>