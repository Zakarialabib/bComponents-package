@props([
    'title' => null,
    'subtitle' => null,
    'showHeader' => true,
    'showFooter' => false,
    'bodyClasses' => '',
    'headerClasses' => '',
    'footerClasses' => '',
    'classes' => '',
])

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if ($showHeader)
        <div class="{{ $headerClasses }}">
            <div>
                @if ($title)
                    <h3 class="text-lg font-medium leading-6">
                        {{ $title }}
                    </h3>
                @endif
                
                @if ($subtitle)
                    <p class="mt-1 text-sm opacity-75">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
            
            @if (isset($header))
                {{ $header }}
            @endif
        </div>
    @endif
    
    <div class="{{ $bodyClasses }}">
        {{ $slot }}
    </div>
    
    @if ($showFooter)
        <div class="{{ $footerClasses }}">
            @if (isset($footer))
                {{ $footer }}
            @endif
        </div>
    @endif
</div> 
