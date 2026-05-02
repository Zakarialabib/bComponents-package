<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class CardComponent extends BaseComponent
{
    /**
     * The card title.
     *
     * @var string|null
     */
    public ?string $title;

    /**
     * The card subtitle.
     *
     * @var string|null
     */
    public ?string $subtitle;

    /**
     * Whether to show the header.
     *
     * @var bool
     */
    public bool $showHeader;

    /**
     * Whether to show the footer.
     *
     * @var bool
     */
    public bool $showFooter;

    /**
     * The card padding.
     *
     * @var string
     */
    public string $padding;

    /**
     * The card shadow.
     *
     * @var string
     */
    public string $shadow;

    /**
     * The card rounded.
     *
     * @var string
     */
    public string $rounded;

    /**
     * The card border.
     *
     * @var bool
     */
    public bool $border;

    /**
     * The card hover effect.
     *
     * @var bool
     */
    public bool $hover;

    /**
     * The component's view name.
     *
     * @var string|null
     */
    protected ?string $view = 'bcomponents::components.card';

    /**
     * The component's default properties.
     *
     * @var array
     */
    protected array $props = [
        'title' => null,
        'subtitle' => null,
        'showHeader' => true,
        'showFooter' => false,
        'padding' => 'md',
        'shadow' => 'md',
        'rounded' => 'md',
        'border' => true,
        'hover' => false,
    ];

    /**
     * The validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'showHeader' => 'boolean',
        'showFooter' => 'boolean',
        'padding' => 'string|in:none,sm,md,lg,xl',
        'shadow' => 'string|in:none,sm,md,lg,xl',
        'rounded' => 'string|in:none,sm,md,lg,xl',
        'border' => 'boolean',
        'hover' => 'boolean',
    ];

    /**
     * The component's base classes.
     *
     * @var string
     */
    protected string $baseClasses = 'bg-white overflow-hidden';

    /**
     * The component's padding classes.
     *
     * @var array
     */
    protected array $paddingClasses = [
        'none' => 'p-0',
        'sm' => 'p-3',
        'md' => 'p-4',
        'lg' => 'p-6',
        'xl' => 'p-8',
    ];

    /**
     * The component's shadow classes.
     *
     * @var array
     */
    protected array $shadowClasses = [
        'none' => '',
        'sm' => 'shadow-sm',
        'md' => 'shadow',
        'lg' => 'shadow-md',
        'xl' => 'shadow-lg',
    ];

    /**
     * The component's rounded classes.
     *
     * @var array
     */
    protected array $roundedClasses = [
        'none' => 'rounded-none',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'xl' => 'rounded-xl',
    ];

    /**
     * Get the view data.
     *
     * @return array
     */
    protected function viewData(): array
    {
        return array_merge(parent::viewData(), [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
            'showHeader' => $this->showHeader && ($this->title || $this->subtitle),
            'showFooter' => $this->showFooter,
            'bodyClasses' => $this->getBodyClasses(),
            'headerClasses' => $this->getHeaderClasses(),
            'footerClasses' => $this->getFooterClasses(),
        ]);
    }

    /**
     * Get the component's classes.
     *
     * @return string
     */
    protected function getClasses(): string
    {
        $classes = parent::getClasses();
        
        $shadowClass = $this->shadowClasses[$this->shadow] ?? $this->shadowClasses['md'];
        $roundedClass = $this->roundedClasses[$this->rounded] ?? $this->roundedClasses['md'];
        $borderClass = $this->border ? 'border border-gray-200' : '';
        $hoverClass = $this->hover ? 'transition-shadow duration-300 hover:shadow-lg' : '';
        
        return trim("{$classes} {$shadowClass} {$roundedClass} {$borderClass} {$hoverClass}");
    }

    /**
     * Get the body classes.
     *
     * @return string
     */
    protected function getBodyClasses(): string
    {
        $paddingClass = $this->paddingClasses[$this->padding] ?? $this->paddingClasses['md'];
        
        return $paddingClass;
    }

    /**
     * Get the header classes.
     *
     * @return string
     */
    protected function getHeaderClasses(): string
    {
        $paddingClass = $this->paddingClasses[$this->padding] ?? $this->paddingClasses['md'];
        
        return "{$paddingClass} border-b border-gray-200";
    }

    /**
     * Get the footer classes.
     *
     * @return string
     */
    protected function getFooterClasses(): string
    {
        $paddingClass = $this->paddingClasses[$this->padding] ?? $this->paddingClasses['md'];
        
        return "{$paddingClass} border-t border-gray-200 bg-gray-50";
    }
} 