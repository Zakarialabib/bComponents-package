<?php

namespace Zakarialabib\BComponents\Components;

use Illuminate\View\ComponentAttributeBag;

class BadgeComponent extends BaseComponent
{
    // Constants for better maintainability
    public const VARIANT_SOLID = 'solid';
    public const VARIANT_OUTLINE = 'outline';
    public const VARIANT_SOFT = 'soft';
    public const VARIANT_DOT = 'dot';
    public const VARIANT_PILL = 'pill';

    // Component properties
    public string $color = 'primary';
    public string $variant = self::VARIANT_SOLID;
    public string $size = 'md';
    public bool $isDismissible = false;
    public bool $isCounter = false;
    public ?string $href = null;
    public ?string $icon = null;
    public string $iconPosition = 'left';
    public bool $isIconOnly = false;
    public ?string $title = null;
    public ?string $wireClick = null;

    // Base CSS classes
    protected string $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-150 ease-in-out relative overflow-hidden select-none';

    // Size-specific classes
    protected array $sizeClasses = [
        'xs' => 'px-1.5 py-0.5 text-xs',
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-2.5 py-1 text-sm',
        'lg' => 'px-3 py-1.5 text-base',
        'xl' => 'px-4 py-2 text-base',
    ];

    // Color-specific classes
    protected array $colorClasses = [
        'primary' => 'bg-indigo-500 text-white hover:bg-indigo-600 focus:ring-indigo-500',
        'secondary' => 'bg-gray-500 text-white hover:bg-gray-600 focus:ring-gray-500',
        'success' => 'bg-green-500 text-white hover:bg-green-600 focus:ring-green-500',
        'danger' => 'bg-red-500 text-white hover:bg-red-600 focus:ring-red-500',
        'warning' => 'bg-yellow-500 text-white hover:bg-yellow-600 focus:ring-yellow-500',
        'info' => 'bg-blue-500 text-white hover:bg-blue-600 focus:ring-blue-500',
        'light' => 'bg-gray-200 text-gray-700 hover:bg-gray-300 focus:ring-gray-200',
        'dark' => 'bg-gray-800 text-white hover:bg-gray-900 focus:ring-gray-700',
    ];

    // Variant-specific classes
    protected array $variantClasses = [
        self::VARIANT_SOLID => '',
        self::VARIANT_OUTLINE => 'bg-transparent border border-current',
        self::VARIANT_SOFT => 'bg-opacity-15 hover:bg-opacity-25',
        self::VARIANT_DOT => 'flex items-center',
        self::VARIANT_PILL => 'rounded-full',
    ];

    /**
     * Get the computed classes for the badge.
     */
    protected function getComputedClasses(): string
    {
        return collect([
            $this->baseClasses,
            $this->sizeClasses[$this->size] ?? '',
            $this->colorClasses[$this->color] ?? '',
            $this->variantClasses[$this->variant] ?? '',
            $this->isCounter ? 'rounded-full' : 'rounded-md',
        ])->filter()->join(' ');
    }

    /**
     * Get the computed attributes for the badge.
     */
    protected function getAttributes(): ComponentAttributeBag
    {
        return $this->attributes->merge([
            'class' => $this->getComputedClasses(),
            'href' => $this->href,
            'title' => $this->title,
        ]);
    }

    /**
     * Render the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.badge', [
            'attributes' => $this->getAttributes(),
            'tag' => $this->href ? 'a' : 'span',
        ]);
    }
}
