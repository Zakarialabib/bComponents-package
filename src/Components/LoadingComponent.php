<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

class LoadingComponent extends BaseComponent
{
    /**
     * The loading type.
     */
    public string $type = 'spinner';

    /**
     * The loading size.
     */
    public string $size = 'md';

    /**
     * The loading color.
     */
    public string $color = 'primary';

    /**
     * The component's view name.
     */
    protected ?string $view = 'bcomponents::components.loading';

    /**
     * The component's default properties.
     */
    protected array $props = [
        'type' => 'spinner',
        'size' => 'md',
        'color' => 'primary',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view($this->getViewName(), $this->viewData());
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'type' => ['string', 'in:spinner,dots,pulse'],
            'size' => ['string', 'in:xs,sm,md,lg,xl'],
            'color' => ['string', 'in:primary,secondary,success,danger,warning,info,dark,light'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    protected function baseClasses(): array
    {
        return array_filter([
            // Base
            'inline-flex',
            
            // Size
            match ($this->size) {
                'xs' => 'w-3 h-3',
                'sm' => 'w-4 h-4',
                'lg' => 'w-6 h-6',
                'xl' => 'w-8 h-8',
                default => 'w-5 h-5',
            },
            
            // Color
            match ($this->color) {
                'secondary' => 'text-gray-500',
                'success' => 'text-green-500',
                'danger' => 'text-red-500',
                'warning' => 'text-yellow-500',
                'info' => 'text-blue-500',
                'dark' => 'text-gray-900',
                'light' => 'text-gray-100',
                default => 'text-primary-500',
            },
            
            // Animation
            match ($this->type) {
                'dots' => 'animate-pulse',
                'pulse' => 'animate-ping',
                default => 'animate-spin',
            },
        ]);
    }
} 
