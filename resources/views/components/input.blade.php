@props([
    'type' => 'text',
    'name' => '',
    'id' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autofocus' => false,
    'prefix' => null,
    'suffix' => null,
    'prefixIcon' => null,
    'suffixIcon' => null,
    'hasPrefix' => false,
    'hasSuffix' => false,
    'hasAddon' => false,
])

@php
    $inputAttributes = [
        'type' => $type,
        'name' => $name,
        'id' => $id ?? $name,
        'value' => $value,
        'placeholder' => $placeholder,
        'class' => $classes,
    ];

    if ($required) $inputAttributes['required'] = true;
    if ($disabled) $inputAttributes['disabled'] = true;
    if ($readonly) $inputAttributes['readonly'] = true;
    if ($autofocus) $inputAttributes['autofocus'] = true;
    
    $componentAttributes = $attributes->merge($inputAttributes);
@endphp

@if ($hasAddon)
    <div class="flex rounded-md shadow-sm">
        @if ($hasPrefix)
            <div class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500">
                @if ($prefixIcon)
                    <x-dynamic-component :component="$prefixIcon" class="h-5 w-5" />
                @endif
                
                @if ($prefix)
                    <span class="text-sm {{ $prefixIcon ? 'ml-1' : '' }}">{{ $prefix }}</span>
                @endif
            </div>
        @endif
        
        <input {{ $componentAttributes }} />
        
        @if ($hasSuffix)
            <div class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500">
                @if ($suffixIcon)
                    <x-dynamic-component :component="$suffixIcon" class="h-5 w-5" />
                @endif
                
                @if ($suffix)
                    <span class="text-sm {{ $suffixIcon ? 'ml-1' : '' }}">{{ $suffix }}</span>
                @endif
            </div>
        @endif
    </div>
@else
    <input {{ $componentAttributes }} />
@endif 