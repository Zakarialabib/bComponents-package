<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\View\Component;

class RadioComponent extends BaseComponent
{
    /**
     * The radio name attribute.
     */
    public string $name;

    /**
     * The radio value attribute.
     */
    public mixed $value = '';

    /**
     * The radio label.
     */
    public ?string $label = null;

    /**
     * Whether the radio is checked.
     */
    public bool $checked = false;

    /**
     * Whether the radio is disabled.
     */
    public bool $disabled = false;

    /**
     * Whether the radio is required.
     */
    public bool $required = false;

    /**
     * The radio size (sm, md, lg).
     */
    public string $size = 'md';

    /**
     * The radio color (primary, secondary, success, danger, warning, info).
     */
    public string $color = 'primary';

    /**
     * Whether to show helper text.
     */
    public bool $helper = false;

    /**
     * The helper text to display.
     */
    public ?string $helperText = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $name,
        mixed $value = '',
        ?string $label = null,
        bool $checked = false,
        bool $disabled = false,
        bool $required = false,
        string $size = 'md',
        string $color = 'primary',
        bool $helper = false,
        ?string $helperText = null
    ) {
        parent::__construct();
        
        $this->name = $name;
        $this->value = $value;
        $this->label = $label;
        $this->checked = $checked;
        $this->disabled = $disabled;
        $this->required = $required;
        $this->size = $size;
        $this->color = $color;
        $this->helper = $helper;
        $this->helperText = $helperText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.radio');
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'value' => ['nullable'],
            'label' => ['nullable', 'string'],
            'checked' => ['boolean'],
            'disabled' => ['boolean'],
            'required' => ['boolean'],
            'size' => ['string', 'in:sm,md,lg'],
            'color' => ['string', 'in:primary,secondary,success,danger,warning,info'],
            'helper' => ['boolean'],
            'helperText' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    protected function baseClasses(): array
    {
        return [
            'form-radio',
            'border-gray-300',
            'text-' . $this->color . '-600',
            'shadow-sm',
            'focus:border-' . $this->color . '-300',
            'focus:ring',
            'focus:ring-' . $this->color . '-200',
            'focus:ring-opacity-50',
            $this->disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer',
            $this->sizeClasses(),
        ];
    }

    /**
     * Get the size classes for the component.
     */
    protected function sizeClasses(): string
    {
        return match ($this->size) {
            'sm' => 'h-4 w-4',
            'lg' => 'h-6 w-6',
            default => 'h-5 w-5',
        };
    }
} 