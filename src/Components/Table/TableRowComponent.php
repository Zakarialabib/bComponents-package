<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components\Table;

use Zakarialabib\BComponents\Components\BaseComponent;

class TableRowComponent extends BaseComponent
{
    /**
     * Whether the row is selected.
     */
    public bool $selected = false;

    /**
     * Whether the row is hoverable.
     */
    public bool $hoverable = true;

    /**
     * Create a new component instance.
     */
    public function __construct(bool $selected = false, bool $hoverable = true)
    {
        parent::__construct();
        $this->selected = $selected;
        $this->hoverable = $hoverable;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.table.row');
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'selected' => ['boolean'],
            'hoverable' => ['boolean'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    protected function baseClasses(): array
    {
        return [
            $this->selected ? 'bg-gray-50' : '',
            $this->hoverable ? 'hover:bg-gray-50' : '',
            'transition-colors',
            'duration-150',
            'ease-in-out',
        ];
    }
} 