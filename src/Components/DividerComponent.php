<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\View\Component;

class DividerComponent extends BaseComponent
{
    /**
     * The divider type (horizontal, vertical).
     */
    public string $type = 'horizontal';

    /**
     * The divider label.
     */
    public ?string $label = null;

    /**
     * The divider label position (left, center, right).
     */
    public string $labelPosition = 'center';

    /**
     * The divider color.
     */
    public string $color = 'gray';

    /**
     * The divider thickness (thin, normal, thick).
     */
    public string $thickness = 'normal';

    /**
     * Create a new component instance.
     */
    public function __construct(
        string $type = 'horizontal',
        ?string $label = null,
        string $labelPosition = 'center',
        string $color = 'gray',
        string $thickness = 'normal'
    ) {
        parent::__construct();
        
        $this->type = $type;
        $this->label = $label;
        $this->labelPosition = $labelPosition;
        $this->color = $color;
        $this->thickness = $thickness;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view('bcomponents::components.divider', $this->viewData());
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'type' => ['string', 'in:horizontal,vertical'],
            'label' => ['nullable', 'string'],
            'labelPosition' => ['string', 'in:left,center,right'],
            'color' => ['string', 'in:gray,primary,secondary,success,danger,warning,info'],
            'thickness' => ['string', 'in:thin,normal,thick'],
        ];
    }

    /**
     * Get the base classes for the component.
     */
    public function baseClasses(): array
    {
        return [
            'relative',
            $this->type === 'vertical' ? 'border-l' : 'border-t',
            $this->borderColorClasses(),
            $this->thicknessClasses(),
            $this->type === 'vertical' ? 'h-full' : 'w-full',
        ];
    }

    /**
     * Get the border color classes for the component.
     */
    protected function borderColorClasses(): string
    {
        return match ($this->color) {
            'primary' => 'border-[color:var(--b-color-primary)]',
            'secondary' => 'border-[color:var(--b-color-secondary)]',
            'success' => 'border-[color:var(--b-color-success)]',
            'danger' => 'border-[color:var(--b-color-danger)]',
            'warning' => 'border-[color:var(--b-color-warning)]',
            'info' => 'border-[color:var(--b-color-info)]',
            default => 'border-[color:var(--b-color-border)]',
        };
    }

    /**
     * Get the thickness classes for the component.
     */
    protected function thicknessClasses(): string
    {
        return match ($this->thickness) {
            'thin' => 'border-[0.5px]',
            'thick' => 'border-2',
            default => 'border',
        };
    }

    /**
     * Get the label position classes for the component.
     */
    public function labelPositionClasses(): string
    {
        return match ($this->labelPosition) {
            'left' => 'left-4',
            'right' => 'right-4',
            default => 'left-1/2 -translate-x-1/2',
        };
    }
} 
