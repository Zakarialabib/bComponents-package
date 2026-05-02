# BComponents Development Plan

## Scope
- Focus only on improving the BaseComponent and Button classes
- Maintain compatibility with existing usage patterns
- Enhance the component's flexibility and reusability
- No need for documentation at this stage

## Current Component Structure

The package currently has two separate component systems:
1. Livewire components (src/Livewire/BaseComponent.php)
2. Blade components (src/Components/ButtonComponent.php)

We need to standardize and improve both systems, starting with the Blade components.

## Current Button Component Structure
```php
class ButtonComponent extends BaseComponent
{
    // Constants for better maintainability
    public const TYPE_BUTTON = 'button';
    public const TYPE_SUBMIT = 'submit';
    public const TYPE_RESET = 'reset';
    public const TYPE_LINK = 'link';

    public const VARIANT_SOLID = 'solid';
    public const VARIANT_OUTLINE = 'outline';
    public const VARIANT_SOFT = 'soft';
    public const VARIANT_GHOST = 'ghost';
    public const VARIANT_LINK = 'link';

    // Component properties
    public string $type = self::TYPE_BUTTON;
    public string $color = 'primary';
    public string $variant = self::VARIANT_SOLID;
    public string $size = 'md';
    public string $rounded = 'md';
    public bool $isDisabled = false;
    public bool $isLoading = false;
    public bool $isActive = false;
    public bool $isBlock = false;
    public ?string $icon = null;
    public string $iconPosition = 'left';
    public bool $isIconOnly = false;
    public ?string $href = null;
    public ?string $wireClick = null;
    public ?string $alpineClick = null;
    public ?string $group = null;
    public ?string $groupPosition = null;
    
    // Additional methods and properties...
}
```

## Refactoring Goals
1. Fix issues with the abstract base component
2. Standardize attribute/prop handling approach
3. Improve variant and state management
4. Enhance class merging and attribute handling
5. Maintain backward compatibility

## BaseComponent Improvements

```php
<?php

// just an example of the namespace
namespace App\View\Components\Base;

use Illuminate\View\Component;
use Illuminate\Support\Arr;

abstract class BaseComponent extends Component
{
    /**
     * Additional CSS classes.
     *
     * @var string
     */
    public $class;

    /**
     * Create the component instance.
     *
     * @param  string  $class
     * @return void
     */
    public function __construct($class = '')
    {
        $this->class = $class;
    }

    /**
     * Merge component classes with additional classes.
     *
     * @param  string|array  $classes
     * @return string
     */
    protected function mergeClasses($classes)
    {
        $classes = is_array($classes) ? implode(' ', $classes) : $classes;
        return trim($classes . ' ' . $this->class);
    }

    /**
     * Get a configuration value with a fallback.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    protected function config($key, $default = null)
    {
        return config('ui-components.' . $key, $default);
    }

    /**
     * Validate enum-like values against allowed options.
     *
     * @param  mixed  $value
     * @param  array  $allowed
     * @param  mixed  $default
     * @return mixed
     */
    protected function validateEnum($value, array $allowed, $default)
    {
        return in_array($value, $allowed) ? $value : $default;
    }

    /**
     * Parse boolean attributes.
     *
     * @param  mixed  $value
     * @return bool
     */
    protected function parseBoolean($value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}
```

## Button Component Improvements

```php
<?php

// just an example of the namespace
namespace App\View\Components\Button;

use App\View\Components\Base\BaseComponent;

class Button extends BaseComponent
{
    /**
     * Available button variants.
     *
     * @var array
     */
    public static $variants = [
        'primary', 'secondary', 'success', 'danger', 'warning', 'info', 
        'dark', 'light', 'link', 'outline-primary', 'outline-secondary'
    ];
    
    /**
     * Available button sizes.
     *
     * @var array
     */
    public static $sizes = ['xs', 'sm', 'md', 'lg', 'xl'];
    
    /**
     * Button type attribute.
     *
     * @var string
     */
    public $type;
    
    /**
     * Button variant.
     *
     * @var string
     */
    public $variant;
    
    /**
     * Button size.
     *
     * @var string
     */
    public $size;
    
    /**
     * Is button disabled.
     *
     * @var bool
     */
    public $disabled;
    
    /**
     * Is button in loading state.
     *
     * @var bool
     */
    public $loading;
    
    /**
     * Button icon.
     *
     * @var string|null
     */
    public $icon;
    
    /**
     * Button icon position.
     *
     * @var string
     */
    public $iconPosition;
    
    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  string  $variant
     * @param  string  $size
     * @param  bool  $disabled
     * @param  bool  $loading
     * @param  string|null  $icon
     * @param  string  $iconPosition
     * @param  string  $class
     * @return void
     */
    public function __construct(
        $type = 'button',
        $variant = 'primary',
        $size = 'md',
        $disabled = false,
        $loading = false,
        $icon = null,
        $iconPosition = 'left',
        $class = ''
    ) {
        parent::__construct($class);
        
        $this->type = $type;
        $this->variant = $this->validateEnum($variant, static::$variants, 'primary');
        $this->size = $this->validateEnum($size, static::$sizes, 'md');
        $this->disabled = $this->parseBoolean($disabled);
        $this->loading = $this->parseBoolean($loading);
        $this->icon = $icon;
        $this->iconPosition = $this->validateEnum($iconPosition, ['left', 'right'], 'left');
    }
    
    /**
     * Get the button variant classes.
     *
     * @return string
     */
    protected function getVariantClasses()
    {
        // First try to get from config if it exists
        $configKey = "buttons.variants.{$this->variant}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        // Fallback to hardcoded classes
        $classes = [
            'primary' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
            'secondary' => 'bg-gray-200 hover:bg-gray-300 text-gray-800 focus:ring-gray-400',
            'success' => 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500',
            'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
            'warning' => 'bg-yellow-500 hover:bg-yellow-600 text-white focus:ring-yellow-400',
            'info' => 'bg-sky-500 hover:bg-sky-600 text-white focus:ring-sky-400',
            'dark' => 'bg-gray-800 hover:bg-gray-900 text-white focus:ring-gray-700',
            'light' => 'bg-gray-100 hover:bg-gray-200 text-gray-800 focus:ring-gray-300',
            'link' => 'bg-transparent hover:underline text-blue-600 focus:ring-blue-500',
            'outline-primary' => 'bg-transparent border border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
            'outline-secondary' => 'bg-transparent border border-gray-400 text-gray-700 hover:bg-gray-50 focus:ring-gray-400',
        ];
        
        return $classes[$this->variant] ?? $classes['primary'];
    }
    
    /**
     * Get the button size classes.
     *
     * @return string
     */
    protected function getSizeClasses()
    {
        // First try to get from config if it exists
        $configKey = "buttons.sizes.{$this->size}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        // Fallback to hardcoded classes
        $classes = [
            'xs' => 'px-2 py-1 text-xs',
            'sm' => 'px-3 py-1.5 text-sm',
            'md' => 'px-4 py-2 text-base',
            'lg' => 'px-5 py-2.5 text-lg',
            'xl' => 'px-6 py-3 text-xl',
        ];
        
        return $classes[$this->size] ?? $classes['md'];
    }
    
    /**
     * Get the state classes based on component state.
     *
     * @return string
     */
    protected function getStateClasses()
    {
        $classes = [];
        
        if ($this->disabled) {
            $classes[] = 'opacity-50 cursor-not-allowed';
        }
        
        return implode(' ', $classes);
    }
    
    /**
     * Get the computed button classes.
     *
     * @return string
     */
    public function computedClasses()
    {
        // Common base classes for all buttons
        $baseClasses = $this->config('buttons.base_classes', 
            'inline-flex items-center justify-center rounded-md font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2'
        );
        
        return $this->mergeClasses([
            $baseClasses,
            $this->getVariantClasses(),
            $this->getSizeClasses(),
            $this->getStateClasses(),
        ]);
    }
    
    /**
     * Determine if the button should show a loading indicator.
     * 
     * @return bool
     */
    public function shouldShowLoading()
    {
        return $this->loading;
    }
    
    /**
     * Determine if the button should show an icon.
     * 
     * @return bool
     */
    public function shouldShowIcon()
    {
        return !$this->loading && $this->icon !== null;
    }
    
    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        // just an example
        return view('components.button.button');
    }
}
```

## Button Blade Template
```blade
{{-- resources/views/components/button/button.blade.php --}}
<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => $computedClasses()]) }}
    {{ $disabled ? 'disabled' : '' }}
>
    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @elseif($icon && $iconPosition === 'left')
        <x-b-icon :name="$icon" class="mr-2 -ml-1 h-5 w-5" />
    @endif
    
    {{ $slot }}
    
    @if($icon && $iconPosition === 'right')
        <x-b-icon :name="$icon" class="ml-2 -mr-1 h-5 w-5" />
    @endif
</button>
```

## Configuration Setup (Optional but Recommended)
```php
<?php
// config/bcomponents.php

return [
    'buttons' => [
        'base_classes' => 'inline-flex items-center justify-center rounded-md font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2',
        'variants' => [
            // Define variants here to override default classes
        ],
        'sizes' => [
            // Define sizes here to override default classes
        ],
    ],
];
```

## Implementation Strategy
1. Update the BaseComponent class first with the improved utility methods
2. Refactor the Button class to use the new BaseComponent features
3. Test with existing instances to ensure backward compatibility
4. Add the optional configuration file if desired

## Key Improvements
- Added validation utilities in the BaseComponent
- Introduced configuration-based styling with hardcoded fallbacks
- Improved state management with dedicated methods
- Enhanced class merging logic
- Added helper methods for template rendering conditions

## Backward Compatibility Notes
- All existing button usage should continue to work without changes
- The class attribute handling remains the same
- All button variants and sizes are preserved
- The Blade template structure supports the same markup patterns