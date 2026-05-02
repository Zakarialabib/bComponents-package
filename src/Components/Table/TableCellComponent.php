<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components\Table;

use Zakarialabib\BComponents\Components\BaseComponent;

class TableCellComponent extends BaseComponent
{
    /**
     * The cell alignment.
     */
    public string $align = 'left';

    /**
     * Whether the cell content should wrap.
     */
    public bool $wrap = false;

    /**
     * Create a new component instance.
     */
    public function __construct(string $align = 'left', bool $wrap = false)
    {
        parent::__construct();
        $this->align = $align;
        $this->wrap = $wrap;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.table.cell', $this->viewData());
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'align' => ['string', 'in:left,center,right'],
            'wrap' => ['boolean'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    public function baseClasses(): array
    {
        return [
            'px-6',
            'py-4',
            $this->wrap ? 'whitespace-normal' : 'whitespace-nowrap',
            'text-sm',
            'text-[color:var(--b-color-text-muted)]',
            'text-' . $this->align,
        ];
    }
} 
