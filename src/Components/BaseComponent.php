<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\View\ComponentAttributeBag;
use Zakarialabib\BComponents\Traits\WithEvents;
use Zakarialabib\BComponents\Traits\WithStyles;
use Zakarialabib\BComponents\Traits\WithValidation;
use Zakarialabib\BComponents\Traits\WithLivewire;

/**
 * Base class for all BComponents.
 */
abstract class BaseComponent extends Component
{
    use WithEvents;
    use WithStyles;
    use WithValidation;
    use WithLivewire;

    /**
     * The component's view name.
     * Child components should override this with their specific view path.
     *
     * @var string|null
     */
    protected ?string $view = null;

    /**
     * The component's default properties.
     * Child components should define their props here.
     *
     * @var array
     */
    protected array $props = [];

    protected array $rawAttributes = [];

    protected bool $initialized = false;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->applyDefaultProps();
    }

    protected function applyDefaultProps(): void
    {
        foreach ($this->props as $propName => $defaultValue) {
            if (!property_exists($this, $propName)) {
                continue;
            }

            $this->{$propName} = $this->castPropValue($defaultValue, $defaultValue);
        }
    }

    public function withAttributes(array $attributes)
    {
        parent::withAttributes($attributes);

        $this->rawAttributes = $attributes;
        $this->initializeProps($attributes);

        if (!$this->initialized) {
            if (method_exists($this, 'initializeEvents')) {
                $this->initializeEvents();
            }

            if (method_exists($this, 'rules') && $this->rules()) {
                $this->validateProps();
            }

            $this->initialized = true;
        }

        return $this;
    }

    /**
     * Initialize component properties from the props array and attributes.
     *
     * @param array $attributes Component attributes
     * @return void
     */
    protected function initializeProps(array $attributes): void
    {
        foreach ($this->props as $propName => $defaultValue) {
            // Handle both camelCase and kebab-case attribute names
            $kebabCase = Str::kebab($propName);

            if (array_key_exists($propName, $attributes)) {
                $value = $attributes[$propName];
            } elseif (array_key_exists($kebabCase, $attributes)) {
                $value = $attributes[$kebabCase];
            } else {
                continue;
            }

            // Only set if the property exists on the class
            if (property_exists($this, $propName)) {
                $this->{$propName} = $this->castPropValue($value, $defaultValue);
            }
        }
    }

    /**
     * Cast the property value to the appropriate type based on the default value.
     *
     * @param mixed $value The value to cast
     * @param mixed $defaultValue The default value, used for type inference
     * @return mixed The casted value
     */
    protected function castPropValue($value, $defaultValue)
    {
        // If the value is null or matches the type, return as is
        if ($value === null || gettype($value) === gettype($defaultValue)) {
            return $value;
        }

        // Cast based on the type of the default value
        return match (gettype($defaultValue)) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'double'  => (float) $value,
            'string'  => (string) $value,
            'array'   => is_array($value) ? $value : (json_decode($value, true) ?: []),
            default   => $value,
        };
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->view !== null) {
            if (!View::exists($this->view)) {
                throw new \RuntimeException("Component view {$this->view} does not exist.");
            }

            return view($this->view, $this->viewData());
        }

        $viewName = $this->guessViewName();

        if (!View::exists($viewName)) {
            throw new \RuntimeException("Component view {$viewName} does not exist.");
        }

        return view($viewName, $this->viewData());
    }

    /**
     * Get the view name for the component.
     *
     * @return string
     */
    protected function getViewName(): string
    {
        return $this->view ?? $this->guessViewName();
    }

    /**
     * Guess the view name for the component based on the class name.
     *
     * @return string
     */
    protected function guessViewName(): string
    {
        $name = class_basename($this);
        $name = Str::replaceLast('Component', '', $name);
        $name = Str::kebab($name);

        return "bcomponents::components.{$name}";
    }

    /**
     * Get the data that should be supplied to the view.
     *
     * @return array
     */
    protected function viewData(): array
    {
        // Get all public properties of the component
        $properties = get_object_vars($this);
        unset($properties['attributes']);

        // Also add the component's class name
        $className = class_basename($this);

        return array_merge(
            $properties,
            [
                'componentName' => $className,
                'componentClass' => static::class,
                'classes' => $this->getClasses(),
            ]
        );
    }

    /**
     * Determine if the component has the given attribute.
     *
     * @param string $key
     * @return bool
     */
    public function hasComponentAttribute(string $key): bool
    {
        $attributes = $this->attributes instanceof ComponentAttributeBag
            ? $this->attributes->getAttributes()
            : (is_array($this->attributes) ? $this->attributes : []);

        return Arr::has($attributes, $key);
    }

    /**
     * Get the value of the given attribute.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getComponentAttribute(string $key, $default = null)
    {
        $attributes = $this->attributes instanceof ComponentAttributeBag
            ? $this->attributes->getAttributes()
            : (is_array($this->attributes) ? $this->attributes : []);

        return Arr::get($attributes, $key, $default);
    }

    /**
     * Determine if the component has a certain property.
     *
     * @param string $name
     * @return bool
     */
    public function hasProp(string $name): bool
    {
        return array_key_exists($name, $this->props);
    }

    /**
     * Base classes for the component.
     * Child components should override this method to define their base classes.
     *
     * @return array|string
     */
    public function baseClasses(): array|string
    {
        return [];
    }

    /**
     * Get the CSS classes for the component.
     *
     * @return string
     */
    protected function getClasses(): string
    {
        $classes = [];

        $baseClassesMethod = new \ReflectionMethod($this, 'baseClasses');
        if ($baseClassesMethod->getDeclaringClass()->getName() !== self::class) {
            $baseClasses = $this->baseClasses();
            if (is_array($baseClasses)) {
                $classes = array_merge($classes, $baseClasses);
            } else {
                $classes[] = (string) $baseClasses;
            }
        } elseif (property_exists($this, 'baseClasses') && is_string($this->baseClasses) && $this->baseClasses !== '') {
            $classes[] = $this->baseClasses;
        }
        
        return implode(' ', array_filter($classes));
    }

    /**
     * Get a configuration value with a fallback.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function config(string $key, $default = null)
    {
        return config("bcomponents.{$key}", $default);
    }

    /**
     * Validate enum-like values against allowed options.
     *
     * @param mixed $value
     * @param array $allowed
     * @param mixed $default
     * @return mixed
     */
    protected function validateEnum($value, array $allowed, $default)
    {
        return in_array($value, $allowed) ? $value : $default;
    }

    /**
     * Merge component classes with additional classes.
     *
     * @param string|array $additionalClasses
     * @return string
     */
    protected function mergeClasses($additionalClasses): string
    {
        $baseClasses = $this->getClasses();

        if (is_array($additionalClasses)) {
            $additionalClasses = implode(' ', array_filter($additionalClasses));
        }

        return trim($baseClasses . ' ' . $additionalClasses);
    }

    /**
     * Parse boolean attributes.
     *
     * @param mixed $value
     * @return bool
     */
    protected function parseBoolean($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get the validation rules for this component.
     * Child components should override this method to define their validation rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Validate the component properties based on the rules.
     */
    protected function validateProps(): void
    {
        $rules = $this->rules();
        
        if (empty($rules)) {
            return;
        }
        
        $data = [];
        foreach ($rules as $property => $rule) {
            if (property_exists($this, $property)) {
                $data[$property] = $this->{$property};
            }
        }
        
        validator($data, $rules)->validate();
    }
}
