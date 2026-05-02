<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

final class BadgeComponent extends BaseComponent
{
    public const VARIANT_SOLID = 'solid';
    public const VARIANT_OUTLINE = 'outline';
    public const VARIANT_SOFT = 'soft';
    public const VARIANT_DOT = 'dot';
    public const VARIANT_PILL = 'pill';

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

    protected ?string $view = 'bcomponents::components.badge';

    protected array $props = [
        'tone' => 'primary',
        'color' => 'primary',
        'variant' => self::VARIANT_SOLID,
        'size' => 'md',
        'dismissible' => false,
        'isDismissible' => false,
        'counter' => false,
        'isCounter' => false,
        'href' => null,
        'icon' => null,
        'iconPosition' => 'left',
        'iconOnly' => false,
        'isIconOnly' => false,
        'title' => null,
    ];

    protected string $baseClasses = 'inline-flex items-center justify-center font-medium transition-all duration-150 ease-in-out relative overflow-hidden select-none';

    protected array $sizeClasses = [
        'xs' => 'px-1.5 py-0.5 text-xs',
        'sm' => 'px-2 py-1 text-xs',
        'md' => 'px-2.5 py-1 text-sm',
        'lg' => 'px-3 py-1.5 text-base',
        'xl' => 'px-4 py-2 text-base',
    ];

    protected array $colorClasses = [
        'primary' => 'bg-[color:var(--b-color-primary)] text-[color:var(--b-color-on-primary)]',
        'secondary' => 'bg-[color:var(--b-color-secondary)] text-[color:var(--b-color-on-primary)]',
        'success' => 'bg-[color:var(--b-color-success)] text-[color:var(--b-color-on-primary)]',
        'danger' => 'bg-[color:var(--b-color-danger)] text-[color:var(--b-color-on-primary)]',
        'warning' => 'bg-[color:var(--b-color-warning)] text-[color:var(--b-color-on-primary)]',
        'info' => 'bg-[color:var(--b-color-info)] text-[color:var(--b-color-on-primary)]',
        'light' => 'bg-[color:var(--b-color-surface-muted)] text-[color:var(--b-color-text)]',
        'dark' => 'bg-[color:var(--b-color-text)] text-[color:var(--b-color-surface)]',
    ];

    protected array $variantClasses = [
        self::VARIANT_SOLID => '',
        self::VARIANT_OUTLINE => 'bg-transparent border border-current',
        self::VARIANT_SOFT => 'bg-opacity-15 hover:bg-opacity-25',
        self::VARIANT_DOT => 'flex items-center',
        self::VARIANT_PILL => 'rounded-full',
    ];

    public function withAttributes(array $attributes)
    {
        if (array_key_exists('tone', $attributes) && !array_key_exists('color', $attributes)) {
            $attributes['color'] = $attributes['tone'];
        }

        if (array_key_exists('dismissible', $attributes) && !array_key_exists('isDismissible', $attributes)) {
            $attributes['isDismissible'] = $attributes['dismissible'];
        }

        if (array_key_exists('counter', $attributes) && !array_key_exists('isCounter', $attributes)) {
            $attributes['isCounter'] = $attributes['counter'];
        }

        if (array_key_exists('iconOnly', $attributes) && !array_key_exists('isIconOnly', $attributes)) {
            $attributes['isIconOnly'] = $attributes['iconOnly'];
        }

        return parent::withAttributes($attributes);
    }

    public function rules(): array
    {
        return [
            'color' => ['string', 'in:primary,secondary,success,danger,warning,info,light,dark'],
            'variant' => ['string', 'in:solid,outline,soft,dot,pill'],
            'size' => ['string', 'in:xs,sm,md,lg,xl'],
            'isDismissible' => ['boolean'],
            'isCounter' => ['boolean'],
            'iconPosition' => ['string', 'in:left,right'],
            'isIconOnly' => ['boolean'],
        ];
    }
}
