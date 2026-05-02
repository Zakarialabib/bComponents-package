<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\View\ComponentAttributeBag;

class AccordionComponent extends BaseComponent
{
    /**
     * Icon position constants
     */
    public const ICON_POSITION_LEFT = 'left';
    public const ICON_POSITION_RIGHT = 'right';
    
    /**
     * Animation constants
     */
    public const ANIMATION_FADE = 'fade';
    public const ANIMATION_SLIDE_UP = 'slide-up';
    public const ANIMATION_SLIDE_DOWN = 'slide-down';
    public const ANIMATION_SLIDE_LEFT = 'slide-left';
    public const ANIMATION_SLIDE_RIGHT = 'slide-right';
    
    /**
     * Size constants
     */
    public const SIZE_SM = 'sm';
    public const SIZE_MD = 'md';
    public const SIZE_LG = 'lg';
    
    /**
     * Accordion properties
     */
    public string $title = '';
    public ?string $id = null;
    public bool $isOpen = false;
    public ?string $icon = null;
    public string $iconPosition = self::ICON_POSITION_RIGHT;
    public bool $isMultiple = false;
    public bool $shouldRemember = false;
    public int $animationDuration = 300;
    public int $headingLevel = 3;
    public string $animation = self::ANIMATION_FADE;
    public string $size = self::SIZE_MD;
    
    /**
     * The component's view name
     */
    protected ?string $view = 'bcomponents::components.accordion';
    
    /**
     * CSS classes
     */
    protected array $classes = [
        'wrapper' => 'w-full my-2 py-5 px-2 rounded-lg group border-solid border-t border-r border-l border-b-2 border-gray-100 shadow-sm',
        'header' => 'flex justify-between items-center text-center py-3 px-2 cursor-pointer',
        'title' => 'text-lg font-bold',
        'icon' => 'w-4 h-4 transition-transform duration-300',
        'content' => 'py-3 mt-2 overflow-hidden transition-all duration-300',
    ];
    
    /**
     * Default properties
     */
    protected array $props = [
        'title' => '',
        'id' => null,
        'isOpen' => false,
        'icon' => null,
        'iconPosition' => self::ICON_POSITION_RIGHT,
        'isMultiple' => false,
        'shouldRemember' => false,
        'animationDuration' => 300,
        'headingLevel' => 3,
        'animation' => self::ANIMATION_FADE,
        'size' => self::SIZE_MD,
    ];
    /**
     * Get validation rules for the component
     */
    public function rules(): array
    {
        return [
            'title' => 'string',
            'id' => 'nullable|string',
            'isOpen' => 'boolean',
            'icon' => 'nullable|string',
            'iconPosition' => 'string|in:left,right',
            'isMultiple' => 'boolean',
            'shouldRemember' => 'boolean',
            'animationDuration' => 'integer|min:0',
            'headingLevel' => 'integer|min:1|max:6',
            'animation' => 'string|in:fade,slide-up,slide-down,slide-left,slide-right',
            'size' => 'string|in:sm,md,lg',
        ];
    }
    
    /**
     * Get the base classes for the component
     */
    public function baseClasses(): array
    {
        return [
            $this->getWrapperClasses(),
            $this->getAccordionSizeClasses(),
        ];
    }
    
    /**
     * Get the wrapper classes for the accordion
     */
    protected function getWrapperClasses(): string
    {
        // Try to get from config if it exists
        $configKey = "components.accordion.base_classes";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        // Fallback to hardcoded classes
        return 'w-full my-2 py-5 px-2 rounded-lg group border-solid border-t border-r border-l border-b-2 border-gray-100 shadow-sm';
    }
    
    /**
     * Get the size classes based on the size property
     */
    protected function getAccordionSizeClasses(): string
    {
        // Try to get from config if it exists
        $configKey = "components.accordion.sizes.{$this->size}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        // Fallback to hardcoded classes
        return match($this->size) {
            self::SIZE_SM => 'text-sm',
            self::SIZE_MD => 'text-base',
            self::SIZE_LG => 'text-lg',
            default => 'text-base',
        };
    }
    
    /**
     * Get the animation classes based on the animation property
     */
    protected function getAnimationClasses(): string
    {
        // Try to get from config if it exists
        $configKey = "components.accordion.animations.{$this->animation}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        // Fallback to hardcoded classes
        return match($this->animation) {
            self::ANIMATION_FADE => 'transition-opacity duration-300',
            self::ANIMATION_SLIDE_UP => 'transition-transform duration-300 transform-gpu',
            self::ANIMATION_SLIDE_DOWN => 'transition-transform duration-300 transform-gpu',
            self::ANIMATION_SLIDE_LEFT => 'transition-transform duration-300 transform-gpu',
            self::ANIMATION_SLIDE_RIGHT => 'transition-transform duration-300 transform-gpu',
            default => 'transition-opacity duration-300',
        };
    }
    
    /**
     * Get the computed attributes for the accordion.
     */
    protected function getAttributes(): ComponentAttributeBag
    {
        // Ensure $this->attributes is a ComponentAttributeBag instance
        $attributes = $this->attributes instanceof ComponentAttributeBag
            ? $this->attributes
            : new ComponentAttributeBag($this->attributes);

        // Get or generate a unique ID
        $id = $attributes->get('id', $this->id ?? uniqid('accordion-'));

        return $attributes->merge([
            'id' => $id,
            'role' => 'region',
            'aria-labelledby' => "accordion-header-{$id}",
            'data-animation' => $this->animation,
            'data-duration' => $this->animationDuration,
            'data-size' => $this->size,
        ]);
    }
    /**
     * Render the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view($this->getViewName(), [
            'attributes' => $this->getAttributes(),
            'classes' => implode(' ', array_filter($this->baseClasses())),
            'animation' => $this->getAnimationClasses(),
            'size' => $this->getAccordionSizeClasses(),
            'headerClasses' => $this->classes['header'],
            'titleClasses' => $this->classes['title'],
            'iconClasses' => $this->classes['icon'],
            'contentClasses' => $this->classes['content'],
        ]);
    }
}
