<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Zakarialabib\BComponents\Support\Styles\InputStyles;

class TextareaComponent extends BaseComponent
{
    public function __construct(
        string $name = '',
        ?string $id = null,
        mixed $value = null,
        ?string $placeholder = null,
        bool $required = false,
        bool $disabled = false,
        bool $invalid = false,
        bool $readonly = false,
        bool $autofocus = false,
        string $size = 'md',
        int $rows = 3,
        ?int $cols = null,
        ?string $resize = null,
    ) {
        parent::__construct();

        $this->name = $name;
        $this->id = $id;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->invalid = $invalid;
        $this->readonly = $readonly;
        $this->autofocus = $autofocus;
        $this->size = $size;
        $this->rows = $rows;
        $this->cols = $cols;
        $this->resize = $resize;
    }

    /**
     * The textarea name.
     *
     * @var string
     */
    public string $name = '';

    /**
     * The textarea id.
     *
     * @var string|null
     */
    public ?string $id = null;

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
    public bool $required = false;

    /**
     * Whether the textarea is disabled.
     *
     * @var bool
     */
    public bool $disabled = false;

    /**
     * Whether the textarea is invalid.
     *
     * @var bool
     */
    public bool $invalid = false;

    /**
     * Whether the textarea is readonly.
     *
     * @var bool
     */
    public bool $readonly = false;

    /**
     * Whether the textarea has autofocus.
     *
     * @var bool
     */
    public bool $autofocus = false;

    /**
     * The textarea size.
     *
     * @var string
     */
    public string $size = 'md';

    /**
     * The textarea rows.
     *
     * @var int
     */
    public int $rows = 3;

    /**
     * The textarea cols.
     *
     * @var int|null
     */
    public ?int $cols = null;

    /**
     * Whether the textarea should resize.
     *
     * @var string|null
     */
    public ?string $resize = null;

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
            'required' => 'boolean',
            'disabled' => 'boolean',
            'invalid' => 'boolean',
            'readonly' => 'boolean',
            'autofocus' => 'boolean',
            'size' => 'string|in:sm,md,lg',
            'rows' => 'integer|min:1',
            'cols' => 'nullable|integer|min:1',
            'resize' => 'nullable|string|in:none,y,x,both',
        ];
    }

    /**
     * The component's base classes.
     *
     * @var string
     */
    protected string $baseClasses = '';

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
            'invalid' => $this->invalid,
            'readonly' => $this->readonly,
            'autofocus' => $this->autofocus,
            'rows' => $this->rows,
            'cols' => $this->cols,
            'resize' => $this->resize,
        ]);
    }

    protected function getClasses(): string
    {
        $classes = InputStyles::classes([
            'size' => $this->size,
            'invalid' => $this->invalid,
            'disabled' => $this->disabled,
        ]);

        return trim($classes . ' ' . $this->getResizeClass());
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
