<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class TextareaComponent extends BaseComponent
{
    /**
     * The textarea name.
     *
     * @var string
     */
    public string $name;

    /**
     * The textarea id.
     *
     * @var string|null
     */
    public ?string $id;

    /**
     * The textarea value.
     *
     * @var mixed
     */
    public $value;

    /**
     * The textarea placeholder.
     *
     * @var string|null
     */
    public ?string $placeholder;

    /**
     * Whether the textarea is required.
     *
     * @var bool
     */
    public bool $required;

    /**
     * Whether the textarea is disabled.
     *
     * @var bool
     */
    public bool $disabled;

    /**
     * Whether the textarea is readonly.
     *
     * @var bool
     */
    public bool $readonly;

    /**
     * Whether the textarea has autofocus.
     *
     * @var bool
     */
    public bool $autofocus;

    /**
     * The textarea rows.
     *
     * @var int
     */
    public int $rows;

    /**
     * The textarea cols.
     *
     * @var int|null
     */
    public ?int $cols;

    /**
     * Whether the textarea should resize.
     *
     * @var string|null
     */
    public ?string $resize;

    /**
     * The component's view name.
     *
     * @var string|null
     */
    protected ?string $view = 'bcomponents::components.textarea';

    /**
     * The component's default properties.
     *
     * @var array
     */
    protected array $props = [
        'name' => '',
        'id' => null,
        'value' => null,
        'placeholder' => null,
        'required' => false,
        'disabled' => false,
        'readonly' => false,
        'autofocus' => false,
        'rows' => 3,
        'cols' => null,
        'resize' => null,
    ];

    /**
     * The validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'name' => 'required|string',
        'required' => 'boolean',
        'disabled' => 'boolean',
        'readonly' => 'boolean',
        'autofocus' => 'boolean',
        'rows' => 'integer|min:1',
        'cols' => 'nullable|integer|min:1',
        'resize' => 'nullable|string|in:none,y,x,both',
    ];

    /**
     * The component's base classes.
     *
     * @var string
     */
    protected string $baseClasses = 'block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500';

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
            'placeholder' => $this->placeholder,
            'required' => $this->required,
            'disabled' => $this->disabled,
            'readonly' => $this->readonly,
            'autofocus' => $this->autofocus,
            'rows' => $this->rows,
            'cols' => $this->cols,
            'resize' => $this->getResizeClass(),
        ]);
    }

    /**
     * Get the resize class.
     *
     * @return string
     */
    protected function getResizeClass(): string
    {
        return match ($this->resize) {
            'none' => 'resize-none',
            'y' => 'resize-y',
            'x' => 'resize-x',
            'both' => 'resize',
            default => '',
        };
    }
} 