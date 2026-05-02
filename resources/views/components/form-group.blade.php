@props([
    'name' => '',
    'label' => null,
    'helpText' => null,
    'showLabel' => true,
    'showError' => true,
    'required' => false,
    'inline' => false,
    'hasError' => false,
    'error' => null,
    'labelClasses' => '',
    'inputWrapperClasses' => '',
])

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if ($inline)
        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start">
    @endif
    
    @if ($showLabel && $label)
        <label for="{{ $name }}" class="{{ $labelClasses }}">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="{{ $inputWrapperClasses }}">
        {{ $slot }}
        
        @if ($helpText)
            <p class="mt-1 text-sm text-gray-500">{{ $helpText }}</p>
        @endif
        
        @if ($showError && $hasError)
            <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
        @endif
    </div>
    
    @if ($inline)
        </div>
    @endif
</div> 