@php($classString = is_array($classes ?? null) ? implode(' ', $classes) : ($classes ?? ''))

<nav aria-label="Breadcrumb">
    <ol class="{{ $classString }}" {{ $attributes->except('class') }}>
        @foreach($items as $index => $item)
            @php($isLast = $index === count($items) - 1)

            <li class="flex items-center space-x-2">
                @if($index > 0)
                    <span class="text-gray-400 select-none" aria-hidden="true">{{ $separator }}</span>
                @endif

                @if(!empty($item['url']) && !$isLast)
                    <a href="{{ $item['url'] }}" class="flex items-center space-x-2 text-gray-500 hover:text-gray-700">
                        @if($showHomeIcon && $index === 0)
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M10.707 1.293a1 1 0 00-1.414 0l-8 8A1 1 0 002 10h1v7a1 1 0 001 1h5v-5a1 1 0 011-1h2a1 1 0 011 1v5h5a1 1 0 001-1v-7h1a1 1 0 00.707-1.707l-8-8z" />
                            </svg>
                        @endif
                        <span>{{ $item['label'] }}</span>
                    </a>
                @else
                    <span class="flex items-center space-x-2 {{ $isLast ? 'text-gray-900 font-medium' : 'text-gray-500' }}" @if($isLast) aria-current="page" @endif>
                        @if($showHomeIcon && $index === 0)
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M10.707 1.293a1 1 0 00-1.414 0l-8 8A1 1 0 002 10h1v7a1 1 0 001 1h5v-5a1 1 0 011-1h2a1 1 0 011 1v5h5a1 1 0 001-1v-7h1a1 1 0 00.707-1.707l-8-8z" />
                            </svg>
                        @endif
                        <span>{{ $item['label'] }}</span>
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
