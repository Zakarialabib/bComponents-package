<div>
    @if($isOpen)
        <div 
            x-data="{ open: @entangle('isOpen').live }"
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                <div 
                    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
                    x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-75"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-75"
                    x-transition:leave-end="opacity-0"
                    @click="!@js($static) && $wire.close()"
                    aria-hidden="true"
                ></div>

                <div 
                    x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    @keydown.escape.window="!@js($static) && $wire.close()"
                    class="relative w-full px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:max-w-lg sm:p-6
                        {{ $size === 'sm' ? 'sm:max-w-sm' : '' }}
                        {{ $size === 'md' ? 'sm:max-w-md' : '' }}
                        {{ $size === 'lg' ? 'sm:max-w-lg' : '' }}
                        {{ $size === 'xl' ? 'sm:max-w-xl' : '' }}
                        {{ $size === '2xl' ? 'sm:max-w-2xl' : '' }}
                        {{ $size === '3xl' ? 'sm:max-w-3xl' : '' }}
                        {{ $size === '4xl' ? 'sm:max-w-4xl' : '' }}
                        {{ $size === '5xl' ? 'sm:max-w-5xl' : '' }}
                        {{ $size === '6xl' ? 'sm:max-w-6xl' : '' }}
                        {{ $size === '7xl' ? 'sm:max-w-7xl' : '' }}
                        {{ $size === 'full' ? 'sm:max-w-full' : '' }}
                        {{ $centered ? 'sm:align-middle' : '' }}
                        {{ $scrollable ? 'overflow-y-auto max-h-[80vh]' : '' }}"
                >
                    @if($title)
                        <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                {{ $title }}
                            </h3>
                            <button 
                                type="button" 
                                class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                wire:click="close"
                            >
                                <span class="sr-only">Close</span>
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div class="mt-3 sm:mt-5">
                        @if($content)
                            {!! $content !!}
                        @else
                            {{ $slot ?? '' }}
                        @endif
                    </div>

                    @if(isset($footer))
                        <div class="mt-5 sm:mt-6 sm:flex sm:flex-row-reverse">
                            {{ $footer }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

