<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\View\Component;

class CheckboxComponent extends BaseComponent
{
    /**
     * The checkbox name attribute.
     */
    public string $name;

    /**
     * The checkbox value attribute.
     */
    public mixed $value = '';

    /**
     * The checkbox label.
     */
    public ?string $label = null;

    /**
     * Whether the checkbox is checked.
     */
    public bool $checked = false;

    /**
     * Whether the checkbox is disabled.
     */
    public bool $disabled = false;

    /**
     * Whether the checkbox is required.
     */
    public bool $required = false;

    /**
     * The checkbox size (sm, md, lg).
     */
    public string $size = 'md';

    /**
     * The checkbox color (primary, secondary, success, danger, warning, info).
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
        return view('bcomponents::components.checkbox');
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
            'form-checkbox',
            'rounded',
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