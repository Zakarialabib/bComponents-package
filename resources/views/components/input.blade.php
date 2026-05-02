@php
    $type = $type ?? 'text';
    $name = $name ?? '';
    $id = $id ?? null;
    $value = $value ?? null;
    $placeholder = $placeholder ?? null;
    $required = $required ?? false;
    $disabled = $disabled ?? false;
    $readonly = $readonly ?? false;
    $autofocus = $autofocus ?? false;
    $prefix = $prefix ?? null;
    $suffix = $suffix ?? null;
    $prefixIcon = $prefixIcon ?? null;
    $suffixIcon = $suffixIcon ?? null;
    $hasPrefix = $hasPrefix ?? false;
    $hasSuffix = $hasSuffix ?? false;
    $hasAddon = $hasAddon ?? false;

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
            <div class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-[color:var(--b-color-border)] bg-[color:var(--b-color-surface-muted)] text-[color:var(--b-color-text-muted)]">
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
            <div class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-[color:var(--b-color-border)] bg-[color:var(--b-color-surface-muted)] text-[color:var(--b-color-text-muted)]">
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
