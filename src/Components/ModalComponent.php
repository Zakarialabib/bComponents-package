<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

class ModalComponent extends BaseComponent
{
    public function __construct(
        string $name = '',
        bool $show = false,
        string $maxWidth = '2xl',
        bool $centered = false,
        bool $scrollable = false,
        bool $static = false,
        ?string $title = null,
    ) {
        parent::__construct();

        $this->name = $name;
        $this->show = $show;
        $this->maxWidth = $maxWidth;
        $this->centered = $centered;
        $this->scrollable = $scrollable;
        $this->static = $static;
        $this->title = $title;
    }

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
    protected ?string $view = 'bcomponents::components.modal';

    protected array $props = [
        'name' => '',
        'show' => false,
        'maxWidth' => '2xl',
        'centered' => false,
        'scrollable' => false,
        'static' => false,
        'title' => null,
    ];
    
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

        return array_merge(parent::viewData(), [
            'maxWidthClass' => $maxWidthClasses[$this->maxWidth] ?? $maxWidthClasses['2xl'],
        ]);
    }
}
