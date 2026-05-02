@props([
    'type' => 'info',
    'dismissible' => false,
    'show' => true,
    'showIcon' => true,
    'title' => null,
    'icon' => null,
    'textColorClass' => 'text-blue-700',
    'iconColorClass' => 'text-blue-400',
    'position' => 'top-right',
    'duration' => null,
    'sound' => false,
    'soundSrc' => null,
    'animation' => 'fade',
    'size' => 'md',
    'closeable' => true,
    'closeOnClick' => false,
    'closeOnEsc' => true,
    'persistent' => false,
    'queue' => false,
    'queueGroup' => 'default',
    'html' => false,
    'role' => 'alert',
    'description' => null,
    'actions' => [],
    'sizeClasses' => '',
    'positionClasses' => '',
    'animationClasses' => '',
])

@if ($show)
    <div 
        {{ $attributes->merge(['class' => $classes]) }}
        x-data="{ 
            open: true,
            init() {
                if (this.$el.getAttribute('data-sound') === 'true' && this.$el.getAttribute('data-sound-src')) {
                    const audio = new Audio(this.$el.getAttribute('data-sound-src'));
                    audio.play();
                }
                if (this.$el.getAttribute('data-duration')) {
                    setTimeout(() => { this.open = false }, parseInt(this.$el.getAttribute('data-duration')));
                }
            }
        }" 
        x-show="open"
        x-transition:enter="{{ $animationClasses }}"
        x-transition:leave="{{ $animationClasses }}"
        @if($closeOnClick) @click.self="open = false" @endif
        @if($closeOnEsc) @keydown.escape.window="open = false" @endif
        role="{{ $role }}"
        data-sound="{{ $sound }}"
        data-sound-src="{{ $soundSrc }}"
        data-duration="{{ $duration }}"
        data-position="{{ $position }}"
        data-queue-group="{{ $queueGroup }}"
        class="fixed {{ $positionClasses }} {{ $sizeClasses }} z-50 max-w-sm w-full">
        <div class="flex">
            @if ($showIcon && $icon)
                <div class="flex-shrink-0">
                    <x-dynamic-component :component="$icon" class="h-5 w-5 {{ $iconColorClass }}" />
                </div>
            @endif
            
            <div class="ml-3 flex-1">
                @if ($title)
                    <h3 class="text-sm font-medium {{ $textColorClass }}">{{ $title }}</h3>
                @endif
                
                <div class="text-sm {{ $textColorClass }} @if($title) mt-2 @endif">
                    @if($html)
                        {!! $slot !!}
                    @else
                        {{ $slot }}
                    @endif

                    @if($description)
                        <p class="mt-1 text-sm opacity-75">{{ $description }}</p>
                    @endif

                    @if(!empty($actions))
                        <div class="mt-3 flex space-x-2">
                            @foreach($actions as $action)
                                <button 
                                    type="button"
                                    @click="$event.preventDefault(); {{ $action['onClick'] ?? '' }}"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 {{ $action['class'] ?? 'text-white bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' }}"
                                >
                                    {{ $action['label'] }}
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            @if ($dismissible)
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button type="button" @click="open = false" class="inline-flex rounded-md p-1.5 {{ $textColorClass }} hover:bg-{{ substr($type, 0, strpos($type, '-') ?: strlen($type)) }}-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ substr($type, 0, strpos($type, '-') ?: strlen($type)) }}-400">
                            <span class="sr-only">Dismiss</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif