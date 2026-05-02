<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components\Table;

use Zakarialabib\BComponents\Components\BaseComponent;

class TableHeaderCellComponent extends BaseComponent
{
    /**
     * The cell alignment.
     */
    public string $align = 'left';

    /**
     * Whether the cell is sortable.
     */
    public bool $sortable = false;

    /**
     * The current sort direction (asc, desc, or null).
     */
    public ?string $sortDirection = null;

    /**
     * Create a new component instance.
     */
    public function __construct(string $align = 'left', bool $sortable = false, ?string $sortDirection = null)
    {
        parent::__construct();
        $this->align = $align;
        $this->sortable = $sortable;
        $this->sortDirection = $sortDirection;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.table.th');
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'align' => ['string', 'in:left,center,right'],
            'sortable' => ['boolean'],
            'sortDirection' => ['nullable', 'string', 'in:asc,desc'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    protected function baseClasses(): array
    {
        return array_filter([
            'px-6',
            'py-3',
            'text-' . $this->align,
            'text-xs',
            'font-medium',
            'text-gray-500',
            'uppercase',
            'tracking-wider',
            $this->sortable ? 'cursor-pointer hover:bg-gray-50' : '',
            'transition-colors',
            'duration-150',
            'ease-in-out',
        ]);
    }
} 