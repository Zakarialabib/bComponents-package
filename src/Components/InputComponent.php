<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Zakarialabib\BComponents\Support\Styles\InputStyles;

class InputComponent extends BaseComponent
{
    /**
     * The input type.
     *
     * @var string
     */
    public string $type;

    /**
     * The input name.
     *
     * @var string
     */
    public string $name;

    /**
     * The input id.
     *
     * @var string|null
     */
    public ?string $id;

    /**
     * The input value.
     *
     * @var mixed
     */
    public $value;

    /**
     * The input placeholder.
     *
     * @var string|null
     */
    public ?string $placeholder;

    /**
     * Whether the input is required.
     *
     * @var bool
     */
    public bool $required;

    /**
     * Whether the input is disabled.
     *
     * @var bool
     */
    public bool $disabled;

    public bool $invalid;

    /**
     * Whether the input is readonly.
     *
     * @var bool
     */
    public bool $readonly;

    /**
     * Whether the input has autofocus.
     *
     * @var bool
     */
    public bool $autofocus;

    /**
     * The input size.
     *
     * @var string
     */
    public string $size;

    /**
     * The input prefix.
     *
     * @var string|null
     */
    public ?string $prefix;

    /**
     * The input suffix.
     *
     * @var string|null
     */
    public ?string $suffix;

    /**
     * The input prefix icon.
     *
     * @var string|null
     */
    public ?string $prefixIcon;

    /**
     * The input suffix icon.
     *
     * @var string|null
     */
    public ?string $suffixIcon;

    /**
     * The component's view name.
     *
     * @var string|null
     */
    protected ?string $view = 'bcomponents::components.input';

    /**
     * The component's default properties.
     *
     * @var array
     */
    protected array $props = [
        'type' => 'text',
        'name' => '',
        'id' => null,
        'value' => null,
        'placeholder' => null,
        'required' => false,
        'disabled' => false,
        'invalid' => false,
        'readonly' => false,
        'autofocus' => false,
        'size' => 'md',
        'prefix' => null,
        'suffix' => null,
        'prefixIcon' => null,
        'suffixIcon' => null,
    ];

    /**
     * The validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'type' => 'string',
        'name' => 'required|string',
        'required' => 'boolean',
        'disabled' => 'boolean',
        'readonly' => 'boolean',
        'autofocus' => 'boolean',
        'size' => 'string|in:xs,sm,md,lg,xl',
    ];

    /**
     * The component's base classes.
     *
     * @var string
     */
    /**
     * Get the view data.
     *
     * @return array
     */
    protected function viewData(): array
    {
        return array_merge(parent::viewData(), [
            'type' => $this->type,
            'name' => $this->name,
            'id' => $this->id ?? $this->name,
            'value' => $this->value,
            'placeholder' => $this->placeholder,
            'required' => $this->required,
            'disabled' => $this->disabled,
            'invalid' => $this->invalid,
            'readonly' => $this->readonly,
            'autofocus' => $this->autofocus,
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
            'prefixIcon' => $this->prefixIcon,
            'suffixIcon' => $this->suffixIcon,
            'hasPrefix' => $this->prefix || $this->prefixIcon,
            'hasSuffix' => $this->suffix || $this->suffixIcon,
            'hasAddon' => ($this->prefix || $this->prefixIcon || $this->suffix || $this->suffixIcon),
        ]);
    }

    /**
     * Get the component's classes.
     *
     * @return string
     */
    protected function getClasses(): string
    {
        $classes = InputStyles::classes([
            'size' => $this->size,
            'invalid' => $this->invalid,
            'disabled' => $this->disabled,
        ]);

        $hasAddon = $this->prefix || $this->prefixIcon || $this->suffix || $this->suffixIcon;
        
        $addonClasses = $hasAddon ? match (true) {
            $this->prefix || $this->prefixIcon => 'rounded-none rounded-r-md',
            $this->suffix || $this->suffixIcon => 'rounded-none rounded-l-md',
            default => '',
        } : '';
        
        return trim("{$classes} {$addonClasses}");
    }
} 
