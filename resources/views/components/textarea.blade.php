@props([
    'name' => '',
    'id' => null,
    'value' => null,
    'placeholder' => null,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'autofocus' => false,
    'rows' => 3,
    'cols' => null,
    'resize' => '',
])

@php
    $textareaAttributes = [
        'name' => $name,
        'id' => $id ?? $name,
        'placeholder' => $placeholder,
        'rows' => $rows,
        'class' => $classes . ' ' . $resize,
    ];

    if ($cols) $textareaAttributes['cols'] = $cols;
    if ($required) $textareaAttributes['required'] = true;
    if ($disabled) $textareaAttributes['disabled'] = true;
    if ($readonly) $textareaAttributes['readonly'] = true;
    if ($autofocus) $textareaAttributes['autofocus'] = true;
    
    $componentAttributes = $attributes->merge($textareaAttributes);
@endphp

<textarea {{ $componentAttributes }}>{{ $value }}</textarea>