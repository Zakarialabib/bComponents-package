<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\View\Component;

class TableComponent extends BaseComponent
{
    /**
     * Whether the table has striped rows.
     */
    public bool $striped = false;

    /**
     * Whether the table has hoverable rows.
     */
    public bool $hoverable = false;

    /**
     * Whether the table is bordered.
     */
    public bool $bordered = false;

    /**
     * Whether the table should be responsive.
     */
    public bool $responsive = true;

    /**
     * Whether the table is compact.
     */
    public bool $compact = false;

    /**
     * The table divider style (none, thin, thick).
     */
    public string $divider = 'thin';

    /**
     * The component's view name.
     */
    protected ?string $view = 'bcomponents::components.table.table';

    /**
     * The component's default properties.
     */
    protected array $props = [
        'striped' => false,
        'hoverable' => false,
        'bordered' => false,
        'compact' => false,
        'divider' => 'thin',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct();
        $this->initializeProps($attributes);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view($this->getViewName(), $this->viewData());
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'striped' => ['boolean'],
            'hoverable' => ['boolean'],
            'bordered' => ['boolean'],
            'compact' => ['boolean'],
            'divider' => ['string', 'in:none,thin,thick'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    public function baseClasses(): array
    {
        return [
            'min-w-full',
            'divide-y',
            'divide-gray-200',
            $this->striped ? 'table-striped' : '',
            $this->hoverable ? 'table-hover' : '',
            $this->bordered ? 'table-bordered' : '',
            $this->compact ? 'table-compact' : '',
            $this->dividerClasses(),
        ];
    }

    /**
     * Get the wrapper classes for responsive tables.
     */
    public function classes(): string
    {
        return implode(' ', array_filter([
            $this->responsive ? 'overflow-x-auto' : '',
            'relative',
            'shadow-sm',
            'rounded-lg',
            'border border-gray-200',
        ]));
    }

    /**
     * Get the divider classes for the component.
     */
    protected function dividerClasses(): string
    {
        return match ($this->divider) {
            'none' => '',
            'thick' => 'divide-y-2',
            default => 'divide-y',
        };
    }
}
