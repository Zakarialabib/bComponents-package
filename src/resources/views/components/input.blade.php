@props([
    'name' => null,
    'id' => null,
    'type' => 'text',
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autocomplete' => null,
    'help' => null,
    'error' => null,
    'wire:model' => null,
    'wire:model.live' => null,
    'wire:model.lazy' => null,
    'wire:model.defer' => null,
])

@php
    $id = $id ?? $name;
    
    // Determine the wire:model directive to use
    $wireModel = null;
    if ($attributes->has('wire:model')) {
        $wireModel = 'wire:model';
    } elseif ($attributes->has('wire:model.live')) {
        $wireModel = 'wire:model.live';
    } elseif ($attributes->has('wire:model.lazy')) {
        $wireModel = 'wire:model.lazy';
    } elseif ($attributes->has('wire:model.defer')) {
        $wireModel = 'wire:model.defer';
    }
    
    // Build the input classes
    $baseClasses = 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full';
    $errorClasses = $error ? 'border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500' : '';
    $disabledClasses = $disabled ? 'bg-gray-100 cursor-not-allowed' : '';
    
    $classes = "{$baseClasses} {$errorClasses} {$disabledClasses} " . ($attributes->get('class') ?? '');
@endphp

<div>
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $id }}"
            @if($wireModel) {{ $wireModel }}="{{ ${$wireModel} }}" @endif
            @if($value && !$wireModel) value="{{ $value }}" @endif
            @if($placeholder) placeholder="{{ $placeholder }}" @endif
            @if($required) required @endif
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            {{ $attributes->merge(['class' => $classes]) }}
        >
        
        @if($type === 'password')
            <div x-data="{ show: false }" class="absolute inset-y-0 right-0 flex items-center pr-3">
                <button
                    type="button"
                    @click="show = !show"
                    class="text-gray-400 hover:text-gray-500 focus:outline-none"
                >
                    <span x-show="!show">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span x-show="show">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                            <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                        </svg>
                    </span>
                </button>
            </div>
            <input
                :type="show ? 'text' : 'password'"
                name="{{ $name }}"
                id="{{ $id }}"
                @if($wireModel) {{ $wireModel }}="{{ ${$wireModel} }}" @endif
                @if($value && !$wireModel) value="{{ $value }}" @endif
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($required) required @endif
                @if($disabled) disabled @endif
                @if($readonly) readonly @endif
                @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
                {{ $attributes->merge(['class' => $classes]) }}
                x-cloak
            >
        @endif
    </div>
    
    @if($help)
        <p class="mt-1 text-sm text-gray-500">{{ $help }}</p>
    @endif
    
    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @elseif($errors ?? null && $name && $errors->has($name))
        <p class="mt-1 text-sm text-red-600">{{ $errors->first($name) }}</p>
    @endif
</div>
