@props([
    'position' => 'static',
    'logoPosition' => 'left',
    'containerWidth' => 'container',
    'logo' => null,
    'isFloating' => false,
    'hasNav' => true,
    'hasShadow' => true,
    'isTransparent' => false,
    'bgColor' => 'white',
    'textColor' => 'gray-800',
    'borderColor' => null,
    'hasBorder' => false,
    'padding' => 'py-4 px-6',
    'zIndex' => 'z-50',
    'mobileBreakpoint' => 'md',
    'isMobileOpen' => false,
])

<header {{ $attributes->merge(['class' => $classes]) }} x-data="{ mobileMenuOpen: {{ $isMobileOpen ? 'true' : 'false' }} }">
    <div class="{{ $containerClasses }}">
        <div class="flex items-center justify-between {{ $padding }}">
            <!-- Logo -->
            @if($logo)
                <div class="{{ $logoPositionClasses }}">
                    {!! $logo !!}
                </div>
            @else
                <div class="{{ $logoPositionClasses }}">
                    <a href="{{ config('app.url') }}" class="flex items-center font-semibold text-lg">
                        {{ $slot->isEmpty() ? config('app.name', 'Application') : $slot }}
                    </a>
                </div>
            @endif

            <!-- Desktop navigation -->
            @if($hasNav)
                <nav class="{{ $mobileBreakpointClass }}">
                    {{ $navigation ?? '' }}
                </nav>
            @endif

            <!-- Mobile navigation toggle -->
            @if($hasNav)
                <div class="flex {{ $mobileBreakpoint }}:hidden">
                    <button 
                        @click="mobileMenuOpen = !mobileMenuOpen" 
                        type="button" 
                        class="text-{{ $textColor }} inline-flex items-center justify-center p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                        aria-controls="mobile-menu"
                        :aria-expanded="mobileMenuOpen"
                    >
                        <span class="sr-only">Open main menu</span>
                        <!-- Icon when menu is closed -->
                        <svg 
                            x-show="!mobileMenuOpen" 
                            class="h-6 w-6" 
                            xmlns="http://www.w3.org/2000/svg" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke="currentColor" 
                            aria-hidden="true"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Icon when menu is open -->
                        <svg 
                            x-show="mobileMenuOpen" 
                            class="h-6 w-6" 
                            xmlns="http://www.w3.org/2000/svg" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke="currentColor" 
                            aria-hidden="true"
                            style="display: none;"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        <!-- Mobile menu -->
        @if($hasNav)
            <div x-show="mobileMenuOpen" class="w-full {{ $mobileBreakpoint }}:hidden" id="mobile-menu" style="display: none;">
                <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                    {{ $mobileNavigation ?? $navigation ?? '' }}
                </div>
            </div>
        @endif
    </div>
</header>
