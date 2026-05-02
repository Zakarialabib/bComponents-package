@props([
    'tag' => 'button',
    'type' => 'button',
    'color' => 'primary',
    'variant' => 'solid',
    'size' => 'md',
    'rounded' => 'md',
    'icon' => null,
    'iconPosition' => 'left',
    'isIconOnly' => false,
    'href' => null,
    'isDisabled' => false,
    'isBlock' => false,
    'isLoading' => false,
    'isActive' => false,
    'wireClick' => null,
    'alpineClick' => null,
    'loadingText' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150';

    $sizeClasses = match($size) {
        'xs' => 'px-2.5 py-1.5 text-xs',
        'sm' => 'px-3 py-2 text-sm leading-4',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-4 py-2 text-base',
        'xl' => 'px-6 py-3 text-base',
        default => 'px-4 py-2 text-sm',
    };

    $roundedClasses = match($rounded) {
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'xl' => 'rounded-xl',
        'full' => 'rounded-full',
        default => 'rounded-md',
    };

    $variantColorClasses = match($variant) {
        'solid' => match($color) {
            'primary' => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white',
            'secondary' => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white',
            'success' => 'bg-green-600 hover:bg-green-700 focus:ring-green-500 text-white',
            'danger' => 'bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white',
            'warning' => 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500 text-white',
            'info' => 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 text-white',
            'light' => 'bg-gray-200 hover:bg-gray-300 focus:ring-gray-200 text-gray-700',
            'dark' => 'bg-gray-800 hover:bg-gray-900 focus:ring-gray-700 text-white',
            default => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white',
        },
        'outline' => match($color) {
            'primary' => 'border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
            'secondary' => 'border border-gray-600 text-gray-600 hover:bg-gray-50 focus:ring-gray-500',
            'success' => 'border border-green-600 text-green-600 hover:bg-green-50 focus:ring-green-500',
            'danger' => 'border border-red-600 text-red-600 hover:bg-red-50 focus:ring-red-500',
            'warning' => 'border border-yellow-600 text-yellow-600 hover:bg-yellow-50 focus:ring-yellow-500',
            'info' => 'border border-indigo-600 text-indigo-600 hover:bg-indigo-50 focus:ring-indigo-500',
            'light' => 'border border-gray-300 text-gray-700 hover:bg-gray-100 focus:ring-gray-200',
            'dark' => 'border border-gray-800 text-gray-800 hover:bg-gray-100 focus:ring-gray-700',
            default => 'border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
        },
        'ghost' => match($color) {
            'primary' => 'text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
            'secondary' => 'text-gray-600 hover:bg-gray-50 focus:ring-gray-500',
            'success' => 'text-green-600 hover:bg-green-50 focus:ring-green-500',
            'danger' => 'text-red-600 hover:bg-red-50 focus:ring-red-500',
            'warning' => 'text-yellow-600 hover:bg-yellow-50 focus:ring-yellow-500',
            'info' => 'text-indigo-600 hover:bg-indigo-50 focus:ring-indigo-500',
            'light' => 'text-gray-600 hover:bg-gray-50 focus:ring-gray-200',
            'dark' => 'text-gray-800 hover:bg-gray-100 focus:ring-gray-700',
            default => 'text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
        },
        'link' => match($color) {
            'primary' => 'text-blue-600 hover:underline focus:ring-blue-500',
            'secondary' => 'text-gray-600 hover:underline focus:ring-gray-500',
            'success' => 'text-green-600 hover:underline focus:ring-green-500',
            'danger' => 'text-red-600 hover:underline focus:ring-red-500',
            'warning' => 'text-yellow-600 hover:underline focus:ring-yellow-500',
            'info' => 'text-indigo-600 hover:underline focus:ring-indigo-500',
            'light' => 'text-gray-600 hover:underline focus:ring-gray-200',
            'dark' => 'text-gray-800 hover:underline focus:ring-gray-700',
            default => 'text-blue-600 hover:underline focus:ring-blue-500',
        },
        default => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white',
    };

    $disabledClasses = $isDisabled ? 'opacity-50 cursor-not-allowed' : '';
    $blockClasses = $isBlock ? 'w-full' : '';
    $activeClasses = $isActive ? 'ring-2' : '';

    // Adjust padding for icon-only buttons
    if ($isIconOnly) {
        $sizeClasses = match($size) {
            'xs' => 'p-1.5',
            'sm' => 'p-2',
            'md' => 'p-2.5',
            'lg' => 'p-3',
            'xl' => 'p-3.5',
            default => 'p-2.5',
        };
    }

    $classes = "{$baseClasses} {$sizeClasses} {$roundedClasses} {$variantColorClasses} {$disabledClasses} {$blockClasses} {$activeClasses}";
@endphp

<{{ $tag }} {{ $attributes->merge(['class' => $classes]) }}>
    @if ($isLoading)
        <span class="inline-flex items-center">
            <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            {{ $loadingText ?? __('Loading...') }}
        </span>
    @else
        <span class="inline-flex items-center">
            @if ($icon && $iconPosition === 'left' && !$isIconOnly)
                <i class="{{ $icon }} {{ $slot->isEmpty() ? '' : 'mr-2' }}"></i>
            @endif

            @unless ($isIconOnly)
                {{ $slot }}
            @else
                @if ($icon)
                    <i class="{{ $icon }}"></i>
                @endif
                <span class="sr-only">{{ $slot }}</span>
            @endunless

            @if ($icon && $iconPosition === 'right' && !$isIconOnly)
                <i class="{{ $icon }} {{ $slot->isEmpty() ? '' : 'ml-2' }}"></i>
            @endif
        </span>
    @endif
</{{ $tag }}>
