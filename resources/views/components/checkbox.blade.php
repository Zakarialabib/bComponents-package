@props([
    'name',
    'value' => '',
    'label' => null,
    'checked' => false,
    'disabled' => false,
    'required' => false,
    'size' => 'md',
    'color' => 'primary',
    'helper' => false,
    'helperText' => null,
])

<div class="flex items-start">
    <div class="flex items-center h-5">
        <input
            type="checkbox"
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ $value }}"
            @checked($checked)
            @disabled($disabled)
            @required($required)
            {{ $attributes->merge(['class' => $classes]) }}
        >
    </div>
    
    @if($label)
        <div class="ml-3 text-sm">
            <label for="{{ $name }}" class="font-medium text-[color:var(--b-color-text)] {{ $disabled ? 'opacity-50' : '' }}">
                {{ $label }}
            </label>
            @if($helper && $helperText)
                <p class="opacity-75">{{ $helperText }}</p>
            @endif
        </div>
    @endif
</div> 
