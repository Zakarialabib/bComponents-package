<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\Support\Arr;
use Illuminate\View\ComponentAttributeBag;

class HeaderComponent extends BaseComponent
{
    /**
     * Position constants
     */
    public const POSITION_STATIC = 'static';
    public const POSITION_FIXED = 'fixed';
    public const POSITION_STICKY = 'sticky';
    public const POSITION_ABSOLUTE = 'absolute';
    public const POSITION_RELATIVE = 'relative';

    /**
     * Logo position constants
     */
    public const LOGO_POSITION_LEFT = 'left';
    public const LOGO_POSITION_CENTER = 'center';
    public const LOGO_POSITION_RIGHT = 'right';

    /**
     * Container width constants
     */
    public const WIDTH_FULL = 'full';
    public const WIDTH_CONTAINER = 'container';
    public const WIDTH_SCREEN = 'screen';

    /**
     * Header properties
     */
    public string $position = self::POSITION_STATIC;
    public string $logoPosition = self::LOGO_POSITION_LEFT;
    public string $containerWidth = self::WIDTH_CONTAINER;
    public ?string $logo = null;
    public bool $isFloating = false;
    public bool $hasNav = true;
    public bool $hasShadow = true;
    public bool $isTransparent = false;
    public string $bgColor = 'white';
    public string $textColor = 'gray-800';
    public ?string $borderColor = null;
    public bool $hasBorder = false;
    public string $padding = 'py-4 px-6';
    public string $zIndex = 'z-50';
    public ?string $mobileBreakpoint = 'md';
    public bool $isMobileOpen = false;

    /**
     * The component's view name
     */
    protected ?string $view = 'bcomponents::components.header';

    /**
     * Default properties
     */
    protected array $props = [
        'position' => self::POSITION_STATIC,
        'logoPosition' => self::LOGO_POSITION_LEFT,
        'containerWidth' => self::WIDTH_CONTAINER,
        'logo' => null,
        'isFloating' => false,
        'hasNav' => true,
        'hasShadow' => true,
        'isTransparent' => false,
        'bgColor' => 'white',
        'textColor' => 'gray-800',
        'borderColor' => null,
        'hasBorder' => false,
        'padding' => 'py-4 px-6',
        'zIndex' => 'z-50',
        'mobileBreakpoint' => 'md',
        'isMobileOpen' => false,
    ];

    /**
     * Get validation rules for the component
     */
    public function rules(): array
    {
        return [
            'position' => 'string|in:static,fixed,sticky,absolute,relative',
            'logoPosition' => 'string|in:left,center,right',
            'containerWidth' => 'string|in:full,container,screen',
            'logo' => 'nullable|string',
            'isFloating' => 'boolean',
            'hasNav' => 'boolean',
            'hasShadow' => 'boolean',
            'isTransparent' => 'boolean',
            'bgColor' => 'string',
            'textColor' => 'string',
            'borderColor' => 'nullable|string',
            'hasBorder' => 'boolean',
            'padding' => 'string',
            'zIndex' => 'string',
            'mobileBreakpoint' => 'nullable|string',
            'isMobileOpen' => 'boolean',
        ];
    }

    /**
     * Get the base classes for the component
     */
    public function baseClasses(): array
    {
        return [
            'w-full',
            $this->getPositionClasses(),
            $this->getBgColorClasses(),
            $this->getTextColorClasses(),
            $this->getShadowClasses(),
            $this->getBorderClasses(),
            $this->zIndex,
        ];
    }

    /**
     * Get position classes for the header
     */
    protected function getPositionClasses(): string
    {
        // Try to get from config if it exists
        $configKey = "components.header.positions.{$this->position}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        // Fallback to hardcoded classes
        $positionClass = match ($this->position) {
            self::POSITION_FIXED => 'fixed top-0 left-0 right-0',
            self::POSITION_STICKY => 'sticky top-0',
            self::POSITION_ABSOLUTE => 'absolute top-0 left-0 right-0',
            self::POSITION_RELATIVE => 'relative',
            default => 'relative', // static
        };

        if ($this->isFloating && in_array($this->position, [self::POSITION_FIXED, self::POSITION_STICKY])) {
            $positionClass .= ' mx-auto my-4 rounded-xl max-w-7xl';
        }
        
        return $positionClass;
    }

    /**
     * Get background color classes
     */
    protected function getBgColorClasses(): string
    {
        // Try to get from config if it exists
        $configKey = "components.header.bg_colors.{$this->bgColor}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        return $this->isTransparent ? 'bg-transparent' : 'bg-' . $this->bgColor;
    }

    /**
     * Get text color classes
     */
    protected function getTextColorClasses(): string
    {
        // Try to get from config if it exists
        $configKey = "components.header.text_colors.{$this->textColor}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        return 'text-' . $this->textColor;
    }

    /**
     * Get shadow classes
     */
    protected function getShadowClasses(): string
    {
        return $this->hasShadow ? 'shadow-md' : '';
    }

    /**
     * Get border classes
     */
    protected function getBorderClasses(): string
    {
        return $this->hasBorder 
            ? 'border-b ' . ($this->borderColor ? 'border-' . $this->borderColor : 'border-gray-200')
            : '';
    }

    /**
     * Get container classes
     */
    public function getContainerClasses(): string
    {
        // Try to get from config if it exists
        $configKey = "components.header.container_widths.{$this->containerWidth}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        return match ($this->containerWidth) {
            self::WIDTH_CONTAINER => 'container mx-auto',
            self::WIDTH_SCREEN => 'max-w-screen-xl mx-auto',
            default => '', // full width
        };
    }

    /**
     * Get logo position classes
     */
    public function getLogoPositionClasses(): string
    {
        // Try to get from config if it exists
        $configKey = "components.header.logo_positions.{$this->logoPosition}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        return match ($this->logoPosition) {
            self::LOGO_POSITION_CENTER => 'mx-auto',
            self::LOGO_POSITION_RIGHT => 'ml-auto',
            default => '', // left aligned
        };
    }

    /**
     * Get mobile breakpoint class
     */
    public function getMobileBreakpointClass(): string
    {
        return $this->mobileBreakpoint ? 'hidden ' . $this->mobileBreakpoint . ':flex' : '';
    }

    /**
     * Get the data that should be supplied to the view.
     */
    protected function viewData(): array
    {
        return array_merge(parent::viewData(), [
            'containerClasses' => $this->getContainerClasses(),
            'logoPositionClasses' => $this->getLogoPositionClasses(),
            'mobileBreakpointClass' => $this->getMobileBreakpointClass(),
        ]);
    }
} 