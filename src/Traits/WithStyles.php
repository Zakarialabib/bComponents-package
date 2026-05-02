<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait WithStyles
{
    /**
     * The component's base classes.
     *
     * @var string
     */
    protected string $baseClasses = '';

    /**
     * The component's size classes.
     *
     * @var array
     */
    protected array $sizeClasses = [
        'xs' => '',
        'sm' => '',
        'md' => '',
        'lg' => '',
        'xl' => '',
    ];

    /**
     * The component's color classes.
     *
     * @var array
     */
    protected array $colorClasses = [
        'primary' => '',
        'secondary' => '',
        'success' => '',
        'danger' => '',
        'warning' => '',
        'info' => '',
        'light' => '',
        'dark' => '',
        'none' => '',
    ];

    /**
     * The component's variant classes.
     *
     * @var array
     */
    protected array $variantClasses = [
        'default' => '',
        'outline' => '',
        'ghost' => '',
        'link' => '',
    ];

    /**
     * The component's state classes.
     *
     * @var array
     */
    protected array $stateClasses = [
        'disabled' => 'opacity-50 cursor-not-allowed',
        'loading' => 'opacity-75 cursor-wait',
        'active' => 'ring-2 ring-offset-2',
        'inactive' => 'opacity-75',
    ];

    /**
     * Get the component's base classes.
     *
     * @return string
     */
    protected function getBaseClasses(): string
    {
        return $this->baseClasses;
    }

    /**
     * Get the component's size classes.
     *
     * @param string|null $size
     * @return string
     */
    protected function getSizeClasses(?string $size = null): string
    {
        $size = $size ?? $this->size ?? 'md';
        
        return $this->sizeClasses[$size] ?? $this->sizeClasses['md'] ?? '';
    }

    /**
     * Get the component's color classes.
     *
     * @param string|null $color
     * @return string
     */
    protected function getColorClasses(?string $color = null): string
    {
        $color = $color ?? $this->color ?? 'primary';
        
        return $this->colorClasses[$color] ?? $this->colorClasses['primary'] ?? '';
    }

    /**
     * Get the component's variant classes.
     *
     * @param string|null $variant
     * @return string
     */
    protected function getVariantClasses(?string $variant = null): string
    {
        $variant = $variant ?? $this->variant ?? 'default';
        
        return $this->variantClasses[$variant] ?? $this->variantClasses['default'] ?? '';
    }

    /**
     * Get the component's state classes.
     *
     * @param string $state
     * @return string
     */
    protected function getStateClasses(string $state): string
    {
        return $this->stateClasses[$state] ?? '';
    }

    /**
     * Get the component's disabled classes.
     *
     * @param bool|null $disabled
     * @return string
     */
    protected function getDisabledClasses(?bool $disabled = null): string
    {
        $disabled = $disabled ?? $this->disabled ?? false;
        
        return $disabled ? $this->getStateClasses('disabled') : '';
    }

    /**
     * Get the component's loading classes.
     *
     * @param bool|null $loading
     * @return string
     */
    protected function getLoadingClasses(?bool $loading = null): string
    {
        $loading = $loading ?? $this->loading ?? false;
        
        return $loading ? $this->getStateClasses('loading') : '';
    }

    /**
     * Get the component's active classes.
     *
     * @param bool|null $active
     * @return string
     */
    protected function getActiveClasses(?bool $active = null): string
    {
        $active = $active ?? $this->active ?? false;
        
        return $active ? $this->getStateClasses('active') : '';
    }

    /**
     * Get the component's classes.
     *
     * @return string
     */
    protected function getClasses(): string
    {
        $baseClasses = $this->getBaseClasses();
        $sizeClasses = $this->getSizeClasses();
        $colorClasses = $this->getColorClasses();
        $variantClasses = $this->getVariantClasses();
        $disabledClasses = $this->getDisabledClasses();
        $loadingClasses = $this->getLoadingClasses();
        $activeClasses = $this->getActiveClasses();
        
        return trim("{$baseClasses} {$sizeClasses} {$colorClasses} {$variantClasses} {$disabledClasses} {$loadingClasses} {$activeClasses}");
    }

    /**
     * Merge the given classes with the component's classes.
     *
     * @param string|array $classes
     * @return string
     */
    protected function mergeClasses($classes): string
    {
        $componentClasses = $this->getClasses();
        
        if (is_array($classes)) {
            $classes = implode(' ', array_filter($classes));
        }
        
        return trim("{$componentClasses} {$classes}");
    }
} 