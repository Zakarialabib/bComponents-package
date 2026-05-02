<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components\Table;

use Zakarialabib\BComponents\Components\BaseComponent;

class TableComponent extends BaseComponent
{
    /**
     * Whether the table should be striped.
     */
    public bool $striped = false;

    /**
     * Whether the table should be responsive.
     */
    public bool $responsive = true;

    /**
     * Whether the table should have borders.
     */
    public bool $bordered = false;

    /**
     * Whether the table should be hoverable.
     */
    public bool $hoverable = true;

    /**
     * Create a new component instance.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->striped = $attributes['striped'] ?? false;
        $this->responsive = $attributes['responsive'] ?? true;
        $this->bordered = $attributes['bordered'] ?? false;
        $this->hoverable = $attributes['hoverable'] ?? true;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.table.table');
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'striped' => ['boolean'],
            'responsive' => ['boolean'],
            'bordered' => ['boolean'],
            'hoverable' => ['boolean'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    protected function baseClasses(): array
    {
        return array_filter([
            'min-w-full',
            'divide-y',
            'divide-gray-200',
            $this->striped ? 'stripe-rows' : '',
            $this->bordered ? 'border border-gray-200' : '',
            $this->hoverable ? 'hover:bg-gray-50' : '',
        ]);
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
} 