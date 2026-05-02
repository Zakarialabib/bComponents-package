# BComponents Contributor Guide

This document is the source-of-truth for how the repository is structured today, how the package is intended to evolve, and how to ship changes without introducing architecture drift.

## Quick Start

```bash
composer install --no-interaction
vendor/bin/phpunit
vendor/bin/phpstan analyse --no-progress --memory-limit=1G
```

## Current Architecture (Code Truth)

### 1) Configuration
- Config file: [bcomponents.php](file:///workspace/config/bcomponents.php)
- Key principles:
  - Minimal, versionable schema
  - Tailwind-only styling baseline
  - Prefix drives both Blade and Livewire tag names

### 2) Blade Component Registration
- Registry: [ComponentRegistry.php](file:///workspace/src/Support/ComponentRegistry.php)
- Service provider: [BComponentsServiceProvider.php](file:///workspace/src/BComponentsServiceProvider.php)
- Behavior:
  - Blade tags are registered as `<x-{prefix}-{alias}>` (default: `<x-b-*>`)
  - Enable/disable is config-driven (`bcomponents.components.enabled`)

### 3) Views (Canonical Root)
- Canonical view root: [resources/views](file:///workspace/resources/views)
- Package view namespace: `bcomponents::...`
- Override behavior:
  - Publish views with `php artisan vendor:publish --tag=bcomponents-views`
  - Edit overrides in `resources/views/vendor/bcomponents/...`

### 4) Styling: Tokens + Recipes
- Tokens are plain CSS variables: [bcomponents.css](file:///workspace/resources/css/bcomponents.css), presets under [themes](file:///workspace/resources/css/themes)
- Recipes are pure PHP class builders:
  - [ButtonStyles.php](file:///workspace/src/Support/Styles/ButtonStyles.php)
  - [InputStyles.php](file:///workspace/src/Support/Styles/InputStyles.php)
  - [SurfaceStyles.php](file:///workspace/src/Support/Styles/SurfaceStyles.php)

### 5) BaseComponent Philosophy (Blade)
Blade BaseComponent exists to share package behavior, not to replace Laravel’s constructor prop system.
- File: [BaseComponent.php](file:///workspace/src/Components/BaseComponent.php)
- Supported:
  - class merging utilities
  - predictable attribute helpers
  - optional validation through `rules()` when components opt-in
- Avoid:
  - “smart” prop hydration that overwrites constructor-provided values
  - silent view guessing that hides missing views

### 6) Livewire Integration
Livewire components exist under [src/Livewire](file:///workspace/src/Livewire).
- They are registered automatically (when enabled) by the package provider.
- Tags match Blade prefix: `<livewire:b-*>` by default.
- Views are in [resources/views/livewire](file:///workspace/resources/views/livewire) and share the same `bcomponents::livewire.*` namespace.

## Public API Conventions

### Canonical naming
Prefer canonical v1 prop names:
- `tone`, `variant`, `size`, `disabled`, `loading`, `invalid`, `fullWidth`, `iconOnly`

### Legacy aliases (deprecation layer)
Some components still accept legacy prop names as aliases:
- Example: `ButtonComponent` still supports `isDisabled` → `disabled`, etc.
- Treat aliases as a migration bridge; do not introduce new aliases unless necessary.

## How to Add or Normalize a Blade Component

1) Implement the component class under [src/Components](file:///workspace/src/Components)
- Prefer constructor props (typed where reasonable) with defaults
- Set explicit `$view = 'bcomponents::components.<name>'`
- Use recipes for computed class strings when possible

2) Implement the Blade view under [resources/views/components](file:///workspace/resources/views/components)
- Use `$attributes->merge(['class' => $classes])` for consistent class merging
- Prefer token variables for color/spacing/radius/shadow

3) Register the component alias
- Add alias → class mapping to [ComponentRegistry.php](file:///workspace/src/Support/ComponentRegistry.php)

4) Add metadata
- Add an entry to [ComponentMetadataRepository.php](file:///workspace/src/Support/Metadata/ComponentMetadataRepository.php)

5) Add tests
- Blade render smoke tests live under [tests/Feature/Components](file:///workspace/tests/Feature/Components)
- Livewire render smoke tests live under [tests/Feature/Livewire](file:///workspace/tests/Feature/Livewire)

6) Verify
```bash
vendor/bin/phpunit
vendor/bin/phpstan analyse --no-progress --memory-limit=1G
```

## Roadmap (Contributor View)

### Phase 1: Architecture stabilization
- Remove stale config references
- Use one canonical view root
- Keep BaseComponent narrow and predictable

### Phase 2: Lock Tier 1 Blade contracts
- Finalize one canonical prop contract per Tier 1 component
- Formalize a11y baselines and add tests for them

### Phase 3: Formalize theming
- Document token families + override contract
- Decide whether to support “consumer-build” Tailwind workflows cleanly

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
