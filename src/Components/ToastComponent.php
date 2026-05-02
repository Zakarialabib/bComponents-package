<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\Support\Arr;

class ToastComponent extends BaseComponent
{
    /**
     * The toast type.
     */
    public string $type = 'info';

    /**
     * The toast position.
     */
    public string $position = 'top-right';

    /**
     * The toast duration in milliseconds.
     */
    public int $duration = 5000;

    /**
     * Whether the toast can be dismissed.
     */
    public bool $dismissible = true;

    /**
     * Whether to show the toast.
     */
    public bool $show = true;

    /**
     * Whether to show the icon.
     */
    public bool $showIcon = true;

    /**
     * The toast title.
     */
    public ?string $title = null;

    /**
     * Custom icon for the toast.
     */
    public ?string $icon = null;

    /**
     * The component's view name.
     */
    protected ?string $view = 'bcomponents::components.toast';

    /**
     * The color classes for different toast types.
     */
    protected array $colorClasses = [
        'info' => 'bg-blue-50 text-blue-800 border-blue-200',
        'success' => 'bg-green-50 text-green-800 border-green-200',
        'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
        'danger' => 'bg-red-50 text-red-800 border-red-200',
        'error' => 'bg-red-50 text-red-800 border-red-200',
    ];

    /**
     * The icon classes for different toast types.
     */
    protected array $iconClasses = [
        'info' => 'text-blue-400',
        'success' => 'text-green-400',
        'warning' => 'text-yellow-400',
        'danger' => 'text-red-400',
        'error' => 'text-red-400',
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(array $attributes = [])
    {
        $this->type = $attributes['type'] ?? 'info';
        $this->position = $attributes['position'] ?? 'top-right';
        $this->duration = $attributes['duration'] ?? 5000;
        $this->dismissible = $attributes['dismissible'] ?? true;
        $this->show = $attributes['show'] ?? true;
        $this->showIcon = $attributes['show-icon'] ?? true;
        $this->title = $attributes['title'] ?? null;
        $this->icon = $attributes['icon'] ?? null;

        parent::__construct();
        $this->initializeProps($attributes);
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'type' => 'string|in:info,success,warning,danger,error',
            'position' => 'string|in:top-right,top-left,bottom-right,bottom-left,top-center,bottom-center',
            'duration' => 'integer|min:0',
            'dismissible' => 'boolean',
            'show' => 'boolean',
            'showIcon' => 'boolean',
            'title' => 'nullable|string',
            'icon' => 'nullable|string',
        ];
    }

    /**
     * Get the base classes for the component.
     */
    public function baseClasses(): array
    {
        return [
            'flex',
            'w-full',
            'max-w-sm',
            'overflow-hidden',
            'rounded-lg',
            'shadow-md',
            'border',
            $this->colorClasses[$this->type] ?? $this->colorClasses['info'],
        ];
    }

    /**
     * Get the position classes for the component.
     */
    protected function positionClasses(): array
    {
        $classes = [
            'top-right' => 'fixed top-4 right-4',
            'top-left' => 'fixed top-4 left-4',
            'bottom-right' => 'fixed bottom-4 right-4',
            'bottom-left' => 'fixed bottom-4 left-4',
            'top-center' => 'fixed top-4 left-1/2 transform -translate-x-1/2',
            'bottom-center' => 'fixed bottom-4 left-1/2 transform -translate-x-1/2',
        ];

        return [$classes[$this->position] ?? $classes['top-right']];
    }

    /**
     * Get the CSS classes for the component.
     */
    protected function getClasses(): string
    {
        return implode(' ', array_merge(
            $this->baseClasses(),
            $this->positionClasses()
        ));
    }

    /**
     * Get the view data.
     */
    protected function viewData(): array
    {
        return array_merge(parent::viewData(), [
            'classes' => $this->getClasses(),
            'iconClass' => $this->iconClasses[$this->type] ?? $this->iconClasses['info'],
        ]);
    }
}
