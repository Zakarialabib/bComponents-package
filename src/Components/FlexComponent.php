<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\View\Component;

class FlexComponent extends BaseComponent
{
    /**
     * The flex direction (row, row-reverse, col, col-reverse).
     */
    public string $direction = 'row';

    /**
     * The flex wrap (wrap, wrap-reverse, nowrap).
     */
    public string $wrap = 'nowrap';

    /**
     * The justify content (start, end, center, between, around, evenly).
     */
    public string $justify = 'start';

    /**
     * The align items (start, end, center, baseline, stretch).
     */
    public string $items = 'start';

    /**
     * The gap size (0-16).
     */
    public int $gap = 0;

    /**
     * The responsive flex direction.
     */
    public ?array $responsive = null;

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $direction = 'row',
        string $wrap = 'nowrap',
        string $justify = 'start',
        string $items = 'start',
        int $gap = 0,
        ?array $responsive = null
    ) {
        parent::__construct();
        
        $this->direction = $direction;
        $this->wrap = $wrap;
        $this->justify = $justify;
        $this->items = $items;
        $this->gap = $gap;
        $this->responsive = $responsive;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.flex');
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'direction' => ['string', 'in:row,row-reverse,col,col-reverse'],
            'wrap' => ['string', 'in:wrap,wrap-reverse,nowrap'],
            'justify' => ['string', 'in:start,end,center,between,around,evenly'],
            'items' => ['string', 'in:start,end,center,baseline,stretch'],
            'gap' => ['integer', 'min:0', 'max:16'],
            'responsive' => ['nullable', 'array'],
            'responsive.*' => ['string', 'in:row,row-reverse,col,col-reverse'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    public function baseClasses(): array
    {
        return [
            'flex',
            $this->directionClasses(),
            'flex-' . $this->wrap,
            'justify-' . $this->justify,
            'items-' . $this->items,
            $this->gapClasses(),
        ];
    }

    /**
     * Get the direction classes for the component.
     */
    protected function directionClasses(): string
    {
        $classes = ['flex-' . $this->direction];

        if ($this->responsive) {
            foreach ($this->responsive as $breakpoint => $direction) {
                $classes[] = $breakpoint . ':flex-' . $direction;
            }
        }

        return implode(' ', $classes);
    }

    /**
     * Get the gap classes for the component.
     */
    protected function gapClasses(): string
    {
        return 'gap-' . $this->gap;
    }
} 
