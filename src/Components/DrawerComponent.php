<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\Support\Arr;

class DrawerComponent extends BaseComponent
{
    /**
     * The drawer name (used for targeting).
     */
    public string $name = '';
    
    /**
     * Whether the drawer is shown by default.
     */
    public bool $show = false;
    
    /**
     * The position of the drawer.
     */
    public string $position = 'right';
    
    /**
     * The width of the drawer.
     */
    public string $width = 'md';
    
    /**
     * Whether the drawer should not close when clicking outside.
     */
    public bool $static = false;
    
    /**
     * The drawer title.
     */
    public ?string $title = null;
    
    /**
     * The component's view name.
     */
    protected string $view = 'bcomponents::components.drawer';
    
    /**
     * Create a new component instance.
     */
    public function __construct(array $attributes = [])
    {
        $this->name = $attributes['name'] ?? '';
        $this->show = $attributes['show'] ?? false;
        $this->position = $attributes['position'] ?? 'right';
        $this->width = $attributes['width'] ?? 'md';
        $this->static = $attributes['static'] ?? false;
        $this->title = $attributes['title'] ?? null;
        
        parent::__construct($attributes);
    }
    
    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'show' => 'boolean',
            'position' => 'string|in:left,right,top,bottom',
            'width' => 'string|in:xs,sm,md,lg,xl,2xl,3xl,4xl,5xl,6xl,7xl,full',
            'static' => 'boolean',
            'title' => 'nullable|string',
        ];
    }
    
    /**
     * Get the view data.
     */
    protected function viewData(): array
    {
        $widthClasses = [
            'xs' => 'w-64',
            'sm' => 'w-72',
            'md' => 'w-80',
            'lg' => 'w-96',
            'xl' => 'w-1/4',
            '2xl' => 'w-1/3',
            '3xl' => 'w-1/2',
            '4xl' => 'w-2/3',
            '5xl' => 'w-3/4',
            '6xl' => 'w-5/6',
            '7xl' => 'w-11/12',
            'full' => 'w-full',
        ];
        
        $positionClasses = [
            'left' => 'inset-y-0 left-0 transform -translate-x-full',
            'right' => 'inset-y-0 right-0 transform translate-x-full',
            'top' => 'inset-x-0 top-0 transform -translate-y-full',
            'bottom' => 'inset-x-0 bottom-0 transform translate-y-full',
        ];
        
        $transitionClasses = [
            'left' => 'translate-x-0',
            'right' => 'translate-x-0',
            'top' => 'translate-y-0',
            'bottom' => 'translate-y-0',
        ];
        
        return [
            'attributes' => $this->attributes(),
            'widthClass' => $widthClasses[$this->width] ?? $widthClasses['md'],
            'positionClass' => $positionClasses[$this->position] ?? $positionClasses['right'],
            'transitionClass' => $transitionClasses[$this->position] ?? $transitionClasses['right'],
            'isVertical' => in_array($this->position, ['left', 'right']),
        ];
    }
}