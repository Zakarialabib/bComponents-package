<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\View\Component;

class SpacerComponent extends BaseComponent
{
    /**
     * The spacer size (0-16).
     */
    public int $size = 4;

    /**
     * The spacer type (horizontal, vertical).
     */
    public string $type = 'vertical';

    /**
     * The responsive spacer sizes.
     */
    public ?array $responsive = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        int $size = 4,
        string $type = 'vertical',
        ?array $responsive = null
    ) {
        parent::__construct();
        
        $this->size = $size;
        $this->type = $type;
        $this->responsive = $responsive;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.spacer', $this->viewData());
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'size' => ['integer', 'min:0', 'max:16'],
            'type' => ['string', 'in:horizontal,vertical'],
            'responsive' => ['nullable', 'array'],
            'responsive.*' => ['integer', 'min:0', 'max:16'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    public function baseClasses(): array
    {
        return [
            $this->type === 'horizontal' ? 'w-full' : 'h-full',
            $this->spacingClasses(),
        ];
    }

    /**
     * Get the spacing classes for the component.
     */
    protected function spacingClasses(): string
    {
        $classes = [$this->type === 'horizontal' ? 'h-' . $this->size : 'w-' . $this->size];

        if ($this->responsive) {
            foreach ($this->responsive as $breakpoint => $size) {
                $classes[] = $breakpoint . ':' . ($this->type === 'horizontal' ? 'h-' : 'w-') . $size;
            }
        }

        return implode(' ', $classes);
    }
} 
