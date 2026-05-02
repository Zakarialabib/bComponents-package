@props([
    'name' => '',
    'id' => null,
    'value' => null,
    'options' => [],
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'invalid' => false,
    'readonly' => false,
    'autofocus' => false,
    'multiple' => false,
    'size' => 'md',
])

@php
    $selectAttributes = [
        'name' => $name,
        'id' => $id ?? $name,
        'class' => $classes,
    ];

    if ($multiple) {
        $selectAttributes['multiple'] = true;
        $selectAttributes['name'] = $name . '[]';
    }
    
    if ($required) $selectAttributes['required'] = true;
    if ($disabled) $selectAttributes['disabled'] = true;
    if ($readonly) $selectAttributes['readonly'] = true;
    if ($autofocus) $selectAttributes['autofocus'] = true;
    
    $componentAttributes = $attributes->merge($selectAttributes);
    
    // Normalize value to array for easier comparison
    $selectedValues = is_array($value) ? $value : [$value];
@endphp

<select {{ $componentAttributes }}>
    @if ($placeholder)
        <option value="" @if(empty($value)) selected @endif>{{ $placeholder }}</option>
    @endif
    
    @foreach ($options as $optionValue => $optionLabel)
        @if (is_array($optionLabel))
            <optgroup label="{{ $optionValue }}">
                @foreach ($optionLabel as $groupOptionValue => $groupOptionLabel)
                    <option value="{{ $groupOptionValue }}" @if(in_array($groupOptionValue, $selectedValues)) selected @endif>
                        {{ $groupOptionLabel }}
                    </option>
                @endforeach
            </optgroup>
        @else
            <option value="{{ $optionValue }}" @if(in_array($optionValue, $selectedValues)) selected @endif>
                {{ $optionLabel }}
            </option>
        @endif
    @endforeach
</select> 
