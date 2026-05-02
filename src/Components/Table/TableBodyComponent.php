<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components\Table;

use Zakarialabib\BComponents\Components\BaseComponent;

class TableBodyComponent extends BaseComponent
{
    /**
     * Whether the rows should be striped.
     */
    public bool $striped = false;

    /**
     * Create a new component instance.
     */
    public function __construct(bool $striped = false)
    {
        parent::__construct();
        $this->striped = $striped;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.table.body', $this->viewData());
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'striped' => ['boolean'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    public function baseClasses(): array
    {
        return [
            'bg-[color:var(--b-color-surface)]',
            'divide-y',
            'divide-[color:var(--b-color-border)]',
            $this->striped ? 'divide-y-0' : '',
        ];
    }
} 
