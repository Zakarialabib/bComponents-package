<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\Support\Arr;

class ModalComponent extends BaseComponent
{
    /**
     * The modal name (used for targeting).
     */
    public string $name = '';
    
    /**
     * Whether the modal is shown by default.
     */
    public bool $show = false;
    
    /**
     * The maximum width of the modal.
     */
    public string $maxWidth = '2xl';
    
    /**
     * Whether the modal should be centered.
     */
    public bool $centered = false;
    
    /**
     * Whether the modal should be scrollable.
     */
    public bool $scrollable = false;
    
    /**
     * Whether the modal should not close when clicking outside.
     */
    public bool $static = false;
    
    /**
     * The modal title.
     */
    public ?string $title = null;
    
    /**
     * The component's view name.
     */
    protected string $view = 'bcomponents::components.modal';
    
    /**
     * Create a new component instance.
     */
    public function __construct(array $attributes = [])
    {
        $this->name = $attributes['name'] ?? '';
        $this->show = $attributes['show'] ?? false;
        $this->maxWidth = $attributes['max-width'] ?? '2xl';
        $this->centered = $attributes['centered'] ?? false;
        $this->scrollable = $attributes['scrollable'] ?? false;
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
            'maxWidth' => 'string|in:sm,md,lg,xl,2xl,3xl,4xl,5xl,6xl,7xl,full',
            'centered' => 'boolean',
            'scrollable' => 'boolean',
            'static' => 'boolean',
            'title' => 'nullable|string',
        ];
    }
    
    /**
     * Get the view data.
     */
    protected function viewData(): array
    {
        $maxWidthClasses = [
            'sm' => 'sm:max-w-sm',
            'md' => 'sm:max-w-md',
            'lg' => 'sm:max-w-lg',
            'xl' => 'sm:max-w-xl',
            '2xl' => 'sm:max-w-2xl',
            '3xl' => 'sm:max-w-3xl',
            '4xl' => 'sm:max-w-4xl',
            '5xl' => 'sm:max-w-5xl',
            '6xl' => 'sm:max-w-6xl',
            '7xl' => 'sm:max-w-7xl',
            'full' => 'sm:max-w-full',
        ];
        
        return [
            'attributes' => $this->attributes(),
            'maxWidthClass' => $maxWidthClasses[$this->maxWidth] ?? $maxWidthClasses['2xl'],
            'centered' => $this->centered,
            'scrollable' => $this->scrollable,
            'static' => $this->static,
        ];
    }
}