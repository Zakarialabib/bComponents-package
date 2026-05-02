@props([
    'name' => '',
    'id' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'invalid' => false,
    'readonly' => false,
    'autofocus' => false,
    'size' => 'md',
    'rows' => 3,
    'cols' => null,
    'resize' => null,
])

@php
    $textareaAttributes = [
        'name' => $name,
        'id' => $id ?? $name,
        'placeholder' => $placeholder,
        'rows' => $rows,
        'class' => $classes,
    ];

    if ($cols) $textareaAttributes['cols'] = $cols;
    if ($required) $textareaAttributes['required'] = true;
    if ($disabled) $textareaAttributes['disabled'] = true;
    if ($readonly) $textareaAttributes['readonly'] = true;
    if ($autofocus) $textareaAttributes['autofocus'] = true;
    
    $componentAttributes = $attributes->merge($textareaAttributes);
@endphp

<textarea {{ $componentAttributes }}>{{ $value }}</textarea>
