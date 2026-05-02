<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Zakarialabib\BComponents\Support\Styles\InputStyles;

class SelectComponent extends BaseComponent
{
    public function __construct(
        string $name = '',
        ?string $id = null,
        mixed $value = null,
        array $options = [],
        ?string $placeholder = null,
        bool $required = false,
        bool $disabled = false,
        bool $invalid = false,
        bool $readonly = false,
        bool $autofocus = false,
        bool $multiple = false,
        string $size = 'md',
    ) {
        parent::__construct();

        $this->name = $name;
        $this->id = $id;
        $this->value = $value;
        $this->options = $options;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->invalid = $invalid;
        $this->readonly = $readonly;
        $this->autofocus = $autofocus;
        $this->multiple = $multiple;
        $this->size = $size;
    }

    /**
     * The select name.
     *
     * @var string
     */
    public string $name = '';

    /**
     * The select id.
     *
     * @var string|null
     */
    public ?string $id = null;

    /**
     * The select value.
     *
     * @var mixed
     */
    public $value;

    /**
     * The select options.
     *
     * @var array
     */
    public array $options = [];

    /**
     * The select placeholder.
     *
     * @var string|null
     */
    public ?string $placeholder;

    /**
     * Whether the select is required.
     *
     * @var bool
     */
    public bool $required = false;

    /**
     * Whether the select is disabled.
     *
     * @var bool
     */
    public bool $disabled = false;

    /**
     * Whether the select is invalid.
     *
     * @var bool
     */
    public bool $invalid = false;

    /**
     * Whether the select is readonly.
     *
     * @var bool
     */
    public bool $readonly = false;

    /**
     * Whether the select has autofocus.
     *
     * @var bool
     */
    public bool $autofocus = false;

    /**
     * Whether the select allows multiple selections.
     *
     * @var bool
     */
    public bool $multiple = false;

    /**
     * The select size.
     *
     * @var string
     */
    public string $size = 'md';

    /**
     * The component's view name.
     *
     * @var string|null
     */
    protected ?string $view = 'bcomponents::components.select';

    /**
     * The component's default properties.
     *
     * @var array
     */
    protected array $props = [];

    /**
     * The validation rules.
     *
     * @var array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'options' => 'required|array',
            'required' => 'boolean',
            'disabled' => 'boolean',
            'invalid' => 'boolean',
            'readonly' => 'boolean',
            'autofocus' => 'boolean',
            'multiple' => 'boolean',
            'size' => 'string|in:xs,sm,md,lg,xl',
        ];
    }

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
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-2 text-sm leading-4',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-4 py-2 text-base',
        'xl' => 'px-6 py-3 text-base',
    ];

    /**
     * Get the view data.
     *
     * @return array
     */
    protected function viewData(): array
    {
        return array_merge(parent::viewData(), [
            'name' => $this->name,
            'id' => $this->id ?? $this->name,
            'value' => $this->value,
            'options' => $this->options,
            'placeholder' => $this->placeholder,
            'required' => $this->required,
            'disabled' => $this->disabled,
            'invalid' => $this->invalid,
            'readonly' => $this->readonly,
            'autofocus' => $this->autofocus,
            'multiple' => $this->multiple,
        ]);
    }

    protected function getClasses(): string
    {
        $classes = InputStyles::classes([
            'size' => $this->size,
            'invalid' => $this->invalid,
            'disabled' => $this->disabled,
        ]);

        return trim($classes . ' appearance-none');
    }

    /**
     * Normalize the options array.
     *
     * @return array
     */
    protected function normalizeOptions(): array
    {
        $normalizedOptions = [];

        foreach ($this->options as $key => $value) {
            if (is_array($value)) {
                // Option group
                $normalizedOptions[] = [
                    'type' => 'group',
                    'label' => $key,
                    'options' => $this->normalizeOptionsArray($value),
                ];
            } else {
                // Regular option
                $normalizedOptions[] = [
                    'type' => 'option',
                    'value' => $key,
                    'label' => $value,
                    'selected' => $this->isOptionSelected($key),
                ];
            }
        }

        return $normalizedOptions;
    }

    /**
     * Normalize an array of options.
     *
     * @param array $options
     * @return array
     */
    protected function normalizeOptionsArray(array $options): array
    {
        $normalizedOptions = [];

        foreach ($options as $key => $value) {
            $normalizedOptions[] = [
                'type' => 'option',
                'value' => $key,
                'label' => $value,
                'selected' => $this->isOptionSelected($key),
            ];
        }

        return $normalizedOptions;
    }

    /**
     * Determine if the given option is selected.
     *
     * @param mixed $key
     * @return bool
     */
    protected function isOptionSelected($key): bool
    {
        if ($this->value === null) {
            return false;
        }

        if (is_array($this->value)) {
            return in_array($key, $this->value);
        }

        return (string) $key === (string) $this->value;
    }
} 
