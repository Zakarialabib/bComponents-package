<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\View\Component;

class GridComponent extends BaseComponent
{
    /**
     * The grid columns (1-12).
     */
    public int $cols = 12;

    /**
     * The grid gap size (0-16).
     */
    public int $gap = 4;

    /**
     * The responsive grid columns.
     */
    public ?array $responsive = null;

    /**
     * Whether to auto-fit columns.
     */
    public bool $autoFit = false;

    /**
     * The minimum width for auto-fit columns.
     */
    public ?string $minWidth = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        int $cols = 12,
        int $gap = 4,
        ?array $responsive = null,
        bool $autoFit = false,
        ?string $minWidth = null
    ) {
        parent::__construct();
        
        $this->cols = $cols;
        $this->gap = $gap;
        $this->responsive = $responsive;
        $this->autoFit = $autoFit;
        $this->minWidth = $minWidth;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.grid');
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'cols' => ['integer', 'min:1', 'max:12'],
            'gap' => ['integer', 'min:0', 'max:16'],
            'responsive' => ['nullable', 'array'],
            'responsive.*' => ['integer', 'min:1', 'max:12'],
            'autoFit' => ['boolean'],
            'minWidth' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    protected function baseClasses(): array
    {
        return [
            'grid',
            $this->gapClasses(),
            $this->gridTemplateColumns(),
        ];
    }

    /**
     * Get the gap classes for the component.
     */
    protected function gapClasses(): string
    {
        return 'gap-' . $this->gap;
    }

    /**
     * Get the grid template columns CSS.
     */
    protected function gridTemplateColumns(): string
    {
        if ($this->autoFit && $this->minWidth) {
            return 'grid-template-columns: repeat(auto-fit, minmax(' . $this->minWidth . ', 1fr))';
        }

        $columns = $this->responsive ? $this->getResponsiveColumns() : 'repeat(' . $this->cols . ', minmax(0, 1fr))';
        return 'grid-template-columns: ' . $columns;
    }

    /**
     * Get the responsive columns CSS.
     */
    protected function getResponsiveColumns(): string
    {
        $breakpoints = [
            'sm' => '640px',
            'md' => '768px',
            'lg' => '1024px',
            'xl' => '1280px',
            '2xl' => '1536px',
        ];

        $css = 'repeat(' . $this->cols . ', minmax(0, 1fr))';

        foreach ($this->responsive as $breakpoint => $cols) {
            if (isset($breakpoints[$breakpoint])) {
                $css .= '@media (min-width: ' . $breakpoints[$breakpoint] . ') { grid-template-columns: repeat(' . $cols . ', minmax(0, 1fr)); }';
            }
        }

        return $css;
    }
} 