<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components\Table;

use Zakarialabib\BComponents\Components\BaseComponent;

class TableHeaderComponent extends BaseComponent
{
    /**
     * Whether the header is sticky.
     */
    public bool $sticky = false;

    /**
     * Create a new component instance.
     */
    public function __construct(bool $sticky = false)
    {
        parent::__construct();
        $this->sticky = $sticky;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.table.header', $this->viewData());
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'sticky' => ['boolean'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    public function baseClasses(): array
    {
        return [
            'bg-[color:var(--b-color-surface-muted)]',
            $this->sticky ? 'sticky top-0 z-10' : '',
        ];
    }
} 
