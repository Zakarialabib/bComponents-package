<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\View\ComponentAttributeBag;
use Zakarialabib\BComponents\Support\Styles\ButtonStyles;

class ButtonComponent extends BaseComponent
{
    public string $type = 'button';
    public string $variant = 'solid';
    public string $size = 'md';
    public string $tone = 'primary';
    public bool $disabled = false;
    public bool $loading = false;
    public bool $fullWidth = false;
    public ?string $icon = null;
    public string $iconPosition = 'left';
    public bool $iconOnly = false;
    public ?string $href = null;
    public ?string $loadingText = null;

    public ?string $color = null;
    public bool $isDisabled = false;
    public bool $isLoading = false;
    public bool $isBlock = false;
    public bool $isIconOnly = false;

    /**
     * The component's view name
     */
    protected ?string $view = 'bcomponents::components.button';

    /**
     * Default properties
     */
    protected array $props = [
        'type' => 'button',
        'variant' => 'solid',
        'size' => 'md',
        'tone' => 'primary',
        'disabled' => false,
        'loading' => false,
        'fullWidth' => false,
        'icon' => null,
        'iconPosition' => 'left',
        'iconOnly' => false,
        'href' => null,
        'loadingText' => null,

        'color' => null,
        'isDisabled' => false,
        'isLoading' => false,
        'isBlock' => false,
        'isIconOnly' => false,
    ];

    protected function getTag(): string
    {
        return $this->href ? 'a' : 'button';
    }

    protected function getAttributes(): ComponentAttributeBag
    {
        $disabled = $this->disabled || $this->isDisabled;
        $attributes = $this->attributes instanceof ComponentAttributeBag
            ? $this->attributes
            : new ComponentAttributeBag(is_array($this->attributes) ? $this->attributes : []);

        return $attributes->merge([
            'type' => $this->href ? null : $this->type,
            'href' => $this->href,
            'disabled' => $this->href ? null : ($disabled ? true : null),
            'aria-disabled' => $disabled ? 'true' : null,
            'role' => $this->href && $disabled ? 'button' : null,
            'tabindex' => $this->href && $disabled ? '-1' : null,
        ]);
    }

    public function render(): \Illuminate\View\View
    {
        $disabled = $this->disabled || $this->isDisabled;
        $loading = $this->loading || $this->isLoading;
        $fullWidth = $this->fullWidth || $this->isBlock;
        $tone = $this->tone ?: ($this->color ?: 'primary');
        $iconOnly = $this->iconOnly || $this->isIconOnly;

        $classes = ButtonStyles::classes([
            'variant' => $this->variant,
            'size' => $this->size,
            'tone' => $tone,
            'disabled' => $disabled,
            'loading' => $loading,
            'full_width' => $fullWidth,
        ]);

        return view($this->getViewName(), array_merge($this->viewData(), [
            'tag' => $this->getTag(),
            'attributes' => $this->getAttributes(),
            'classes' => $classes,
            'icon' => $this->icon,
            'iconPosition' => $this->iconPosition,
            'isIconOnly' => $iconOnly,
            'isLoading' => $loading,
            'loadingText' => $this->loadingText,
        ]));
    }
}
