<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ContainerComponent extends BaseComponent
{
    /**
     * The container max width.
     *
     * @var string
     */
    public string $maxWidth;

    /**
     * The container padding.
     *
     * @var string
     */
    public string $padding;

    /**
     * Whether the container is centered.
     *
     * @var bool
     */
    public bool $centered;

    /**
     * The component's view name.
     *
     * @var string|null
     */
    protected ?string $view = 'bcomponents::components.container';

    /**
     * The component's default properties.
     *
     * @var array
     */
    protected array $props = [
        'maxWidth' => '7xl',
        'padding' => 'md',
        'centered' => true,
    ];

    /**
     * The validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'maxWidth' => 'string|in:sm,md,lg,xl,2xl,3xl,4xl,5xl,6xl,7xl,full',
        'padding' => 'string|in:none,sm,md,lg,xl',
        'centered' => 'boolean',
    ];

    /**
     * The component's base classes.
     *
     * @var string
     */
    protected string $baseClasses = 'w-full';

    /**
     * The component's max width classes.
     *
     * @var array
     */
    protected array $maxWidthClasses = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
        '6xl' => 'max-w-6xl',
        '7xl' => 'max-w-7xl',
        'full' => 'max-w-full',
    ];

    /**
     * The component's padding classes.
     *
     * @var array
     */
    protected array $paddingClasses = [
        'none' => 'px-0',
        'sm' => 'px-2 sm:px-4',
        'md' => 'px-4 sm:px-6',
        'lg' => 'px-6 sm:px-8',
        'xl' => 'px-8 sm:px-10',
    ];

    /**
     * Get the component's classes.
     *
     * @return string
     */
    protected function getClasses(): string
    {
        $classes = parent::getClasses();
        
        $maxWidthClass = $this->maxWidthClasses[$this->maxWidth] ?? $this->maxWidthClasses['7xl'];
        $paddingClass = $this->paddingClasses[$this->padding] ?? $this->paddingClasses['md'];
        $centeredClass = $this->centered ? 'mx-auto' : '';
        
        return trim("{$classes} {$maxWidthClass} {$paddingClass} {$centeredClass}");
    }
} 