<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\View\Component;

class ToggleComponent extends BaseComponent
{
    /**
     * The toggle name attribute.
     */
    public string $name;

    /**
     * The toggle value attribute.
     */
    public mixed $value = '';

    /**
     * The toggle label.
     */
    public ?string $label = null;

    /**
     * Whether the toggle is checked.
     */
    public bool $checked = false;

    /**
     * Whether the toggle is disabled.
     */
    public bool $disabled = false;

    /**
     * Whether the toggle is required.
     */
    public bool $required = false;

    /**
     * The toggle size (sm, md, lg).
     */
    public string $size = 'md';

    /**
     * The toggle color (primary, secondary, success, danger, warning, info).
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
     * Whether to show icons in the toggle.
     */
    public bool $icons = false;

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
        ?string $helperText = null,
        bool $icons = false
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
        $this->icons = $icons;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.toggle');
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
            'icons' => ['boolean'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    protected function baseClasses(): array
    {
        return [
            'relative',
            'inline-flex',
            'flex-shrink-0',
            'transition-colors',
            'ease-in-out',
            'duration-200',
            'border-2',
            'border-transparent',
            'rounded-full',
            'cursor-pointer',
            'focus:outline-none',
            'focus:ring-2',
            'focus:ring-offset-2',
            'focus:ring-' . $this->color . '-500',
            $this->checked ? 'bg-' . $this->color . '-600' : 'bg-gray-200',
            $this->disabled ? 'opacity-50 cursor-not-allowed' : '',
            $this->sizeClasses()['toggle'],
        ];
    }

    /**
     * Get the size classes for the component.
     */
    protected function sizeClasses(): array
    {
        return match ($this->size) {
            'sm' => [
                'toggle' => 'h-4 w-8',
                'button' => 'h-3 w-3',
                'translate' => 'translate-x-4',
            ],
            'lg' => [
                'toggle' => 'h-8 w-16',
                'button' => 'h-7 w-7',
                'translate' => 'translate-x-8',
            ],
            default => [
                'toggle' => 'h-6 w-12',
                'button' => 'h-5 w-5',
                'translate' => 'translate-x-6',
            ],
        };
    }

    /**
     * Get the button classes for the component.
     */
    public function buttonClasses(): string
    {
        return implode(' ', [
            'pointer-events-none',
            'inline-block',
            'rounded-full',
            'bg-white',
            'shadow',
            'transform',
            'ring-0',
            'transition',
            'ease-in-out',
            'duration-200',
            $this->checked ? $this->sizeClasses()['translate'] : 'translate-x-0',
            $this->sizeClasses()['button'],
        ]);
    }
} 