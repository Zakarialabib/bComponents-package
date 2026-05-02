@props([
    'position' => 'static',
    'logoPosition' => 'left',
    'containerWidth' => 'container',
    'logo' => null,
    'isFloating' => false,
    'hasNav' => true,
    'hasShadow' => false,
    'isTransparent' => false,
    'bgColor' => 'gray-800',
    'textColor' => 'white',
    'borderColor' => null,
    'hasBorder' => false,
    'padding' => 'py-8 px-6',
    'zIndex' => 'z-40',
    'copyright' => null,
    'hasSocialIcons' => false,
    'socialLinks' => [],
    'hasColumns' => true,
    'columnCount' => 4,
])

<footer {{ $attributes->merge(['class' => $classes]) }}>
    <div class="{{ $containerClasses }}">
        @if($hasColumns)
            <div class="grid {{ $columnGridClasses }} gap-8 mb-8">
                {{ $columns ?? '' }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-center">
            <!-- Logo -->
            @if($logo)
                <div class="{{ $logoPositionClasses }}">
                    {!! $logo !!}
                </div>
            @elseif(!$slot->isEmpty())
                <div class="{{ $logoPositionClasses }}">
                    <a href="{{ config('app.url') }}" class="flex items-center font-semibold text-lg">
                        {{ $slot }}
                    </a>
                </div>
            @endif

            <!-- Navigation -->
            @if($hasNav)
                <nav class="mt-4 md:mt-0">
                    {{ $navigation ?? '' }}
                </nav>
            @endif

            <!-- Social Icons -->
            @if($hasSocialIcons)
                <div class="flex space-x-4 mt-4 md:mt-0">
                    @forelse($socialLinks as $link)
                        <a href="{{ $link['url'] ?? '#' }}" class="text-{{ $textColor }} hover:text-gray-400 transition-colors duration-300" aria-label="{{ $link['name'] ?? 'Social link' }}">
                            @if(isset($link['icon']))
                                <x-dynamic-component :component="$link['icon']" class="h-5 w-5" />
                            @elseif(isset($link['svg']))
                                {!! $link['svg'] !!}
                            @else
                                <span>{{ $link['name'] ?? '' }}</span>
                            @endif
                        </a>
                    @empty
                        {{ $socialIcons ?? '' }}
                    @endforelse
                </div>
            @endif
        </div>

        <!-- Copyright -->
        @if($copyright)
            <div class="mt-8 text-center text-sm text-gray-400">
                {!! $copyright !!}
            </div>
        @endif
    </div>
</footer>
