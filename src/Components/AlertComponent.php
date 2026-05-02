<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\Support\Arr;

class AlertComponent extends BaseComponent
{
    /**
     * Alert type constants
     */
    public const TYPE_INFO = 'info';
    public const TYPE_SUCCESS = 'success';
    public const TYPE_WARNING = 'warning';
    public const TYPE_DANGER = 'danger';
    public const TYPE_ERROR = 'error';

    /**
     * Alert animation constants
     */
    public const ANIMATION_FADE = 'fade';
    public const ANIMATION_SLIDE_UP = 'slide-up';
    public const ANIMATION_SLIDE_DOWN = 'slide-down';
    public const ANIMATION_SLIDE_LEFT = 'slide-left';
    public const ANIMATION_SLIDE_RIGHT = 'slide-right';

    /**
     * Alert position constants
     */
    public const POSITION_TOP_RIGHT = 'top-right';
    public const POSITION_TOP_LEFT = 'top-left';
    public const POSITION_TOP_CENTER = 'top-center';
    public const POSITION_BOTTOM_RIGHT = 'bottom-right';
    public const POSITION_BOTTOM_LEFT = 'bottom-left';
    public const POSITION_BOTTOM_CENTER = 'bottom-center';

    /**
     * Alert size constants
     */
    public const SIZE_SM = 'sm';
    public const SIZE_MD = 'md';
    public const SIZE_LG = 'lg';

    /**
     * The alert type.
     */
    public string $type = self::TYPE_INFO;

    /**
     * Whether the alert can be dismissed.
     */
    public bool $dismissible = false;

    /**
     * Whether to show the alert.
     */
    public bool $show = true;

    /**
     * Whether to show the icon.
     */
    public bool $showIcon = true;

    /**
     * The alert title.
     */
    public ?string $title = null;

    /**
     * Custom icon for the alert.
     */
    public ?string $icon = null;

    /**
     * The alert position.
     */
    public string $position = self::POSITION_TOP_RIGHT;

    /**
     * The duration to show the alert in milliseconds. Null for no auto-hide.
     */
    public ?int $duration = null;

    /**
     * Whether to play a sound when the alert is shown.
     */
    public bool $sound = false;

    /**
     * The sound source URL.
     */
    public ?string $soundSrc = null;

    /**
     * The animation type to use.
     */
    public string $animation = self::ANIMATION_FADE;

    /**
     * The size of the alert.
     */
    public string $size = self::SIZE_MD;

    /**
     * Whether the alert is persistent (cannot be dismissed).
     */
    public bool $persistent = false;

    /**
     * Whether the alert can be closed.
     */
    public bool $closeable = true;

    /**
     * Whether to close the alert when clicked.
     */
    public bool $closeOnClick = false;

    /**
     * Whether to close the alert when Esc key is pressed.
     */
    public bool $closeOnEsc = true;

    /**
     * Whether to queue the alert.
     */
    public bool $queue = false;

    /**
     * The queue group for the alert.
     */
    public string $queueGroup = 'default';

    /**
     * Whether to render HTML in the alert content.
     */
    public bool $html = false;

    /**
     * The ARIA role for the alert.
     */
    public string $role = 'alert';

    /**
     * Additional description text.
     */
    public ?string $description = null;

    /**
     * Alert actions.
     */
    public array $actions = [];

    /**
     * The component's view name.
     */
    protected ?string $view = 'bcomponents::components.alert';

    /**
     * The component's default properties.
     */
    protected array $props = [
        'type' => self::TYPE_INFO,
        'dismissible' => false,
        'show' => true,
        'showIcon' => true,
        'title' => null,
        'icon' => null,
        'position' => self::POSITION_TOP_RIGHT,
        'duration' => null,
        'sound' => false,
        'soundSrc' => null,
        'animation' => self::ANIMATION_FADE,
        'size' => self::SIZE_MD,
        'closeable' => true,
        'closeOnClick' => false,
        'closeOnEsc' => true,
        'persistent' => false,
        'queue' => false,
        'queueGroup' => 'default',
        'html' => false,
        'role' => 'alert',
        'description' => null,
        'actions' => [],
    ];

    /**
     * Create a new component instance.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): \Illuminate\View\View
    {
        return view($this->getViewName(), array_merge($this->viewData(), [
            'classes' => implode(' ', array_filter($this->baseClasses())),
        ]));
    }

    /**
     * Get the validation rules that apply to the component.
     */
    public function rules(): array
    {
        return [
            'type' => 'string|in:info,success,warning,danger,error',
            'dismissible' => 'boolean',
            'show' => 'boolean',
            'showIcon' => 'boolean',
            'title' => 'nullable|string',
            'icon' => 'nullable|string',
            'position' => 'string|in:top-right,top-left,top-center,bottom-right,bottom-left,bottom-center',
            'duration' => 'nullable|integer|min:0',
            'sound' => 'boolean',
            'soundSrc' => 'nullable|string',
            'animation' => 'string|in:fade,slide-up,slide-down,slide-left,slide-right',
            'size' => 'string|in:sm,md,lg',
            'closeable' => 'boolean',
            'closeOnClick' => 'boolean',
            'closeOnEsc' => 'boolean',
            'persistent' => 'boolean',
            'queue' => 'boolean',
            'queueGroup' => 'string',
            'html' => 'boolean',
            'role' => 'string',
            'description' => 'nullable|string',
            'actions' => 'array',
        ];
    }

    /**
     * Get the base classes for the component.
     */
    public function baseClasses(): array
    {
        // Try to get from config first
        $configKey = "components.alert.variants.{$this->type}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return [$configClasses];
        }
        
        return [
            'rounded-md',
            'p-4',
            $this->getAlertColorClasses(),
        ];
    }

    /**
     * Get the view data.
     */
    protected function viewData(): array
    {
        return array_merge(parent::viewData(), [
            'type' => $this->type,
            'dismissible' => $this->dismissible,
            'show' => $this->show,
            'showIcon' => $this->showIcon,
            'title' => $this->title,
            'icon' => $this->icon ?? $this->getDefaultIcon(),
            'textColorClass' => $this->getTextColorClass(),
            'iconColorClass' => $this->getIconColorClass(),
            'position' => $this->position,
            'duration' => $this->duration,
            'sound' => $this->sound,
            'soundSrc' => $this->soundSrc,
            'animation' => $this->animation,
            'size' => $this->size,
            'closeable' => $this->closeable,
            'closeOnClick' => $this->closeOnClick,
            'closeOnEsc' => $this->closeOnEsc,
            'persistent' => $this->persistent,
            'queue' => $this->queue,
            'queueGroup' => $this->queueGroup,
            'html' => $this->html,
            'role' => $this->role,
            'description' => $this->description,
            'actions' => $this->actions,
            'sizeClasses' => $this->getAlertSizeClasses(),
            'positionClasses' => $this->getAlertPositionClasses(),
            'animationClasses' => $this->getAlertAnimationClasses(),
        ]);
    }

    /**
     * Get the default icon for the alert type.
     */
    protected function getDefaultIcon(): string
    {
        // Try to get from config first
        $configKey = "components.alert.icons.{$this->type}";
        $configIcon = $this->config($configKey);
        
        if ($configIcon) {
            return $configIcon;
        }
        
        return match ($this->type) {
            self::TYPE_INFO => 'heroicon-o-information-circle',
            self::TYPE_SUCCESS => 'heroicon-o-check-circle',
            self::TYPE_WARNING => 'heroicon-o-exclamation',
            self::TYPE_DANGER, self::TYPE_ERROR => 'heroicon-o-x-circle',
            default => 'heroicon-o-information-circle',
        };
    }

    /**
     * Get the text color class for the alert type.
     */
    protected function getTextColorClass(): string
    {
        // Try to get from config first
        $configKey = "components.alert.text_colors.{$this->type}";
        $configClass = $this->config($configKey);
        
        if ($configClass) {
            return $configClass;
        }
        
        return match ($this->type) {
            self::TYPE_INFO => 'text-blue-700',
            self::TYPE_SUCCESS => 'text-green-700',
            self::TYPE_WARNING => 'text-yellow-700',
            self::TYPE_DANGER, self::TYPE_ERROR => 'text-red-700',
            default => 'text-blue-700',
        };
    }

    /**
     * Get the icon color class for the alert type.
     */
    protected function getIconColorClass(): string
    {
        // Try to get from config first
        $configKey = "components.alert.icon_colors.{$this->type}";
        $configClass = $this->config($configKey);
        
        if ($configClass) {
            return $configClass;
        }
        
        return match ($this->type) {
            self::TYPE_INFO => 'text-blue-400',
            self::TYPE_SUCCESS => 'text-green-400',
            self::TYPE_WARNING => 'text-yellow-400',
            self::TYPE_DANGER, self::TYPE_ERROR => 'text-red-400',
            default => 'text-blue-400',
        };
    }

    /**
     * Get the size classes based on the size property.
     */
    protected function getAlertSizeClasses(): string
    {
        // Try to get from config first
        $configKey = "components.alert.sizes.{$this->size}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        return match ($this->size) {
            self::SIZE_SM => 'text-xs p-2',
            self::SIZE_LG => 'text-base p-6',
            default => 'text-sm p-4',
        };
    }

    /**
     * Get the position classes based on the position property.
     */
    protected function getAlertPositionClasses(): string
    {
        // Try to get from config first
        $configKey = "components.alert.positions.{$this->position}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        return match ($this->position) {
            self::POSITION_TOP_LEFT => 'top-0 left-0',
            self::POSITION_TOP_CENTER => 'top-0 left-1/2 transform -translate-x-1/2',
            self::POSITION_TOP_RIGHT => 'top-0 right-0',
            self::POSITION_BOTTOM_LEFT => 'bottom-0 left-0',
            self::POSITION_BOTTOM_CENTER => 'bottom-0 left-1/2 transform -translate-x-1/2',
            self::POSITION_BOTTOM_RIGHT => 'bottom-0 right-0',
            default => 'top-0 right-0',
        };
    }

    /**
     * Get the animation classes based on the animation property.
     */
    protected function getAlertAnimationClasses(): string
    {
        // Try to get from config first
        $configKey = "components.alert.animations.{$this->animation}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        return match ($this->animation) {
            self::ANIMATION_SLIDE_UP => 'transition transform duration-300 ease-in-out transform-gpu translate-y-0 opacity-100 enter:translate-y-full enter:opacity-0 leave:translate-y-full leave:opacity-0',
            self::ANIMATION_SLIDE_DOWN => 'transition transform duration-300 ease-in-out transform-gpu -translate-y-0 opacity-100 enter:-translate-y-full enter:opacity-0 leave:-translate-y-full leave:opacity-0',
            self::ANIMATION_SLIDE_LEFT => 'transition transform duration-300 ease-in-out transform-gpu translate-x-0 opacity-100 enter:translate-x-full enter:opacity-0 leave:translate-x-full leave:opacity-0',
            self::ANIMATION_SLIDE_RIGHT => 'transition transform duration-300 ease-in-out transform-gpu -translate-x-0 opacity-100 enter:-translate-x-full enter:opacity-0 leave:-translate-x-full leave:opacity-0',
            default => 'transition-opacity duration-300 ease-in-out opacity-100 enter:opacity-0 leave:opacity-0',
        };
    }

    /**
     * Get the background and border classes for the alert type.
     */
    protected function getAlertColorClasses(): string
    {
        // Try to get from config first
        $configKey = "components.alert.colors.{$this->type}";
        $configClasses = $this->config($configKey);
        
        if ($configClasses) {
            return $configClasses;
        }
        
        $colorMap = [
            self::TYPE_INFO => 'bg-blue-50 border-l-4 border-blue-400',
            self::TYPE_SUCCESS => 'bg-green-50 border-l-4 border-green-400',
            self::TYPE_WARNING => 'bg-yellow-50 border-l-4 border-yellow-400',
            self::TYPE_DANGER => 'bg-red-50 border-l-4 border-red-400',
            self::TYPE_ERROR => 'bg-red-50 border-l-4 border-red-400',
        ];
        
        return $colorMap[$this->type] ?? $colorMap[self::TYPE_INFO];
    }
}