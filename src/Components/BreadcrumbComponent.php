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
    protected ?string $view = 'bcomponents::components.breadcrumb';

    /**
     * The component's default properties.
     */
    public function __construct(
        array $items = [],
        string $separator = '/',
        bool $showHomeIcon = true
    ) {
        parent::__construct();
        $this->items = $items;
        $this->separator = $separator;
        $this->showHomeIcon = $showHomeIcon;
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
    public function baseClasses(): array
    {
        return [
            'flex',
            'items-center',
            'space-x-2',
            'text-sm',
            'text-[color:var(--b-color-text-muted)]',
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
            $isLast ? 'text-[color:var(--b-color-text)] font-medium' : 'text-[color:var(--b-color-text-muted)] hover:text-[color:var(--b-color-text)]',
        ];
    }

    /**
     * Get the separator classes.
     */
    protected function separatorClasses(): array
    {
        return [
            'text-[color:var(--b-color-text-muted)]',
            'select-none',
        ];
    }
} 
