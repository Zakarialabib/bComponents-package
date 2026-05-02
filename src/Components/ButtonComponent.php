<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\Support\Arr;
use Illuminate\View\ComponentAttributeBag;

class ButtonComponent extends BaseComponent
{
    /**
     * Button type constants
     */
    public const TYPE_BUTTON = 'button';
    public const TYPE_SUBMIT = 'submit';
    public const TYPE_RESET = 'reset';
    public const TYPE_LINK = 'link';

    /**
     * Button variant constants
     */
    public const VARIANT_SOLID = 'solid';
    public const VARIANT_OUTLINE = 'outline';
    public const VARIANT_SOFT = 'soft';
    public const VARIANT_GHOST = 'ghost';
    public const VARIANT_LINK = 'link';

    /**
     * Button color constants
     */
    public const COLOR_PRIMARY = 'primary';
    public const COLOR_SECONDARY = 'secondary';
    public const COLOR_SUCCESS = 'success';
    public const COLOR_DANGER = 'danger';
    public const COLOR_WARNING = 'warning';
    public const COLOR_INFO = 'info';
    public const COLOR_LIGHT = 'light';
    public const COLOR_DARK = 'dark';

    /**
     * Button properties
     */
    public string $type = self::TYPE_BUTTON;
    public string $color = self::COLOR_PRIMARY;
    public string $variant = self::VARIANT_SOLID;
    public string $size = 'md';
    public string $rounded = 'md';
    public bool $isDisabled = false;
    public bool $isLoading = false;
    public bool $isActive = false;
    public bool $isBlock = false;
    public ?string $icon = null;
    public string $iconPosition = 'left';
    public bool $isIconOnly = false;
    public ?string $href = null;
    public ?string $wireClick = null;
    public ?string $alpineClick = null;
    public ?string $group = null;
    public ?string $groupPosition = null;
    public ?string $loadingText = null;

    /**
     * The component's view name
     */
    protected ?string $view = 'bcomponents::components.button';

    /**
     * Default properties
     */
    protected array $props = [
        'type' => self::TYPE_BUTTON,
        'color' => self::COLOR_PRIMARY,
        'variant' => self::VARIANT_SOLID,
        'size' => 'md',
        'rounded' => 'md',
        'isDisabled' => false,
        'isLoading' => false,
        'isActive' => false,
        'isBlock' => false,
        'icon' => null,
        'iconPosition' => 'left',
        'isIconOnly' => false,
        'href' => null,
        'wireClick' => null,
        'alpineClick' => null,
        'group' => null,
        'groupPosition' => null,
        'loadingText' => null,
    ];

    /**
     * Get validation rules for the component
     */
    public function rules(): array
    {
        return [
            'type' => 'string|in:button,submit,reset,link',
            'color' => 'string|in:primary,secondary,success,danger,warning,info,dark,light',
            'size' => 'string|in:xs,sm,md,lg,xl',
            'variant' => 'string|in:solid,outline,soft,ghost,link',
            'rounded' => 'string|in:none,sm,md,lg,full',
            'isDisabled' => 'boolean',
            'isLoading' => 'boolean',
            'isActive' => 'boolean',
            'isBlock' => 'boolean',
            'icon' => 'nullable|string',
            'iconPosition' => 'string|in:left,right',
            'isIconOnly' => 'boolean',
            'href' => 'nullable|string',
            'wireClick' => 'nullable|string',
            'alpineClick' => 'nullable|string',
            'group' => 'nullable|string',
            'groupPosition' => 'nullable|string|in:first,middle,last',
            'loadingText' => 'nullable|string',
        ];
    }

    /**
     * Get the base classes for the component
     */
    public function baseClasses(): array
    {
        return [
            'inline-flex',
            'items-center',
            'justify-center',
            'font-medium',
            'focus:outline-none',
            'focus:ring-2',
            'focus:ring-offset-2',
            'transition-all',
            'duration-150',
            'ease-in-out',
            'relative',
            'overflow-hidden',
            'select-none',
            $this->getRoundedClasses(),
            $this->getButtonSizeClasses(),
            $this->getButtonVariantClasses(),
            $this->getButtonStateClasses(),
        ];
    }

    /**
     * Get the computed tag for the button
     */
    protected function getTag(): string
    {
        return $this->href ? 'a' : 'button';
    }

    /**
     * Get the size classes based on the size property
     */
    protected function getButtonSizeClasses(): string
    {
        // Try to get from config if it exists
        $configKey = "components.button.sizes.{$this->size}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        // Fallback to hardcoded classes
        return match($this->size) {
            'xs' => 'px-2.5 py-1.5 text-xs',
            'sm' => 'px-3 py-2 text-sm leading-4',
            'md' => 'px-4 py-2 text-sm',
            'lg' => 'px-4 py-2 text-base',
            'xl' => 'px-6 py-3 text-base',
            default => 'px-4 py-2 text-sm',
        };
    }

    /**
     * Get the rounded classes based on the rounded property
     */
    protected function getRoundedClasses(): string
    {
        return match($this->rounded) {
            'none' => 'rounded-none',
            'sm' => 'rounded-sm',
            'md' => 'rounded-md',
            'lg' => 'rounded-lg',
            'full' => 'rounded-full',
            default => 'rounded-md',
        };
    }

    /**
     * Get variant-specific color classes
     */
    protected function getButtonVariantClasses(): string
    {
        // Try to get from config first
        $configKey = "components.button.variants.{$this->variant}.{$this->color}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        // Get the color-based classes
        $colorClasses = $this->getButtonColorClasses($this->color);
        
        // Apply variant modifications
        return match($this->variant) {
            self::VARIANT_OUTLINE => str_replace(
                ['bg-', 'hover:bg-'], 
                ['bg-transparent border border-', 'hover:bg-opacity-10 hover:bg-'], 
                $colorClasses
            ),
            self::VARIANT_SOFT => str_replace(
                ['bg-', 'text-white'], 
                ['bg-opacity-20 bg-', "text-{$this->color}-700"], 
                $colorClasses
            ),
            self::VARIANT_GHOST => str_replace(
                ['bg-', 'text-white'], 
                ['bg-transparent hover:bg-opacity-10 hover:bg-', "text-{$this->color}-600"], 
                $colorClasses
            ),
            self::VARIANT_LINK => "bg-transparent text-{$this->color}-600 hover:underline focus:ring-0",
            default => $colorClasses, // VARIANT_SOLID
        };
    }

    /**
     * Get the base color classes
     */
    protected function getButtonColorClasses(string $color): string
    {
        return match($color) {
            self::COLOR_PRIMARY => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white',
            self::COLOR_SECONDARY => 'bg-gray-600 hover:bg-gray-700 focus:ring-gray-500 text-white',
            self::COLOR_SUCCESS => 'bg-green-600 hover:bg-green-700 focus:ring-green-500 text-white',
            self::COLOR_DANGER => 'bg-red-600 hover:bg-red-700 focus:ring-red-500 text-white',
            self::COLOR_WARNING => 'bg-yellow-600 hover:bg-yellow-700 focus:ring-yellow-500 text-white',
            self::COLOR_INFO => 'bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 text-white',
            self::COLOR_LIGHT => 'bg-gray-200 hover:bg-gray-300 focus:ring-gray-200 text-gray-700',
            self::COLOR_DARK => 'bg-gray-800 hover:bg-gray-900 focus:ring-gray-700 text-white',
            default => 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 text-white',
        };
    }

    /**
     * Get state-specific classes
     */
    protected function getButtonStateClasses(): string
    {
        $classes = [];
        
        if ($this->isBlock) {
            $classes[] = 'w-full';
        }
        
        if ($this->isDisabled) {
            $classes[] = 'opacity-50 cursor-not-allowed';
        }
        
        if ($this->isActive) {
            $classes[] = 'ring-2';
        }
        
        // Add group position classes if in a button group
        if ($this->group && $this->groupPosition) {
            $classes[] = match($this->groupPosition) {
                'first' => 'rounded-r-none border-r-0',
                'middle' => 'rounded-none border-r-0',
                'last' => 'rounded-l-none',
                default => '',
            };
        }
        
        return implode(' ', $classes);
    }

    /**
     * Get the computed attributes for the button
     */
    protected function getAttributes(): ComponentAttributeBag
    {
        // Ensure attributes is a ComponentAttributeBag instance
        $attributes = $this->attributes instanceof ComponentAttributeBag
            ? $this->attributes
            : new ComponentAttributeBag($this->attributes);

        return $attributes->merge([
            'type' => $this->href ? null : $this->type,
            'href' => $this->href,
            'disabled' => $this->isDisabled,
            'aria-disabled' => $this->isDisabled ? 'true' : null,
            'wire:click' => $this->wireClick,
            'x-on:click' => $this->alpineClick,
            'x-data' => '{ isLoading: ' . ($this->isLoading ? 'true' : 'false') . ' }',
        ]);
    }

    /**
     * Render the component
     */
    public function render(): \Illuminate\View\View
    {
        return view($this->getViewName(), array_merge($this->viewData(), [
            'tag' => $this->getTag(),
            'attributes' => $this->getAttributes(),
            'classes' => implode(' ', array_filter($this->baseClasses())),
        ]));
    }
}
