<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

class BreadcrumbComponent extends BaseComponent
{
    /**
     * The breadcrumb items.
     */
    public array $items = [];

    /**
     * The separator between items.
     */
    public string $separator = '/';

    /**
     * Whether to show the home icon.
     */
    public bool $showHomeIcon = true;

    /**
     * The component's view name.
     */
    protected string $view = 'bcomponents::components.breadcrumb';

    /**
     * The component's default properties.
     */
    protected array $props = [
        'items' => [],
        'separator' => '/',
        'showHomeIcon' => true,
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
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
            'items' => ['array'],
            'items.*.label' => ['required', 'string'],
            'items.*.url' => ['nullable', 'string'],
            'separator' => ['string'],
            'showHomeIcon' => ['boolean'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    protected function baseClasses(): array
    {
        return [
            'flex',
            'items-center',
            'space-x-2',
            'text-sm',
            'text-gray-500',
        ];
    }

    /**
     * Get the item classes.
     */
    protected function itemClasses(bool $isLast = false): array
    {
        return [
            'flex',
            'items-center',
            'space-x-2',
            $isLast ? 'text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-700',
        ];
    }

    /**
     * Get the separator classes.
     */
    protected function separatorClasses(): array
    {
        return [
            'text-gray-400',
            'select-none',
        ];
    }
} 