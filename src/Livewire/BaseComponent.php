<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Zakarialabib\BComponents\Traits\WithEvents;
use Zakarialabib\BComponents\Traits\WithStyles;
use Zakarialabib\BComponents\Traits\WithValidation;
use Zakarialabib\BComponents\Traits\WithLivewire;
use Closure;

abstract class BaseComponent extends Component
{
    use WithEvents;
    use WithStyles;
    use WithValidation;
    use WithLivewire;

    /**
     * The component's listeners.
     *
     * @var array
     */
    protected $listeners = [];

    /**
     * Indicates if the component should be rendered lazily.
     *
     * @var bool
     */
    protected $lazy = true;

    /**
     * The component's view name.
     *
     * @var string
     */
    protected string $view;

    /**
     * The component's default properties.
     *
     * @var array
     */
    protected array $props = [];

    /**
     * Initialize the component.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->initializeProps();
        $this->initializeEvents();
        $this->initializeWithLivewire();
    }

    /**
     * Initialize the component's properties.
     *
     * @return void
     */
    protected function initializeProps(): void
    {
        foreach ($this->props as $key => $defaultValue) {
            if (!property_exists($this, $key) || $this->{$key} === null) {
                $this->{$key} = $defaultValue;
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render()
    {
        return view($this->getViewName(), $this->viewData());
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
        
        return "livewire.{$name}";
    }

    /**
     * Get the data that should be supplied to the view.
     *
     * @return array
     */
    protected function viewData(): array
    {
        return [
            'classes' => $this->getClasses(),
        ];
    }

    /**
     * Reset the component's properties to their initial state.
     *
     * @param array|string|null $properties
     * @return $this
     */
    public function resetProps($properties = null)
    {
        $properties = is_array($properties) 
            ? $properties 
            : array_filter(func_get_args());

        if (empty($properties)) {
            $properties = array_keys($this->props);
        }

        foreach ($properties as $property) {
            $this->{$property} = $this->props[$property] ?? null;
        }

        return $this;
    }

    /**
     * Validate the component's properties.
     *
     * @param array $rules
     * @param array $messages
     * @param array $attributes
     * @return array
     */
    public function validateProps(array $rules = [], array $messages = [], array $attributes = []): array
    {
        return $this->validate($rules, $messages, $attributes);
    }

    /**
     * Dispatch a browser event.
     *
     * @param string $event
     * @param mixed $data
     * @return $this
     */
    public function dispatchBrowserEvent(string $event, $data = null)
    {
        if (method_exists(parent::class, 'dispatchBrowserEvent')) {
            // Livewire v2 method
            parent::dispatchBrowserEvent($event, $data);
        } else {
            // Livewire v3 method
            $this->dispatch('browser-event', [
                'name' => $event,
                'data' => $data,
            ]);
        }

        return $this;
    }

    /**
     * Show a notification.
     *
     * @param string $message
     * @param string $type
     * @param int $duration
     * @return $this
     */
    public function notify(string $message, string $type = 'success', int $duration = 3000)
    {
        $this->dispatchBrowserEvent('notify', [
            'message' => $message,
            'type' => $type,
            'duration' => $duration,
        ]);

        return $this;
    }

    /**
     * Show a success notification.
     *
     * @param string $message
     * @param int $duration
     * @return $this
     */
    public function notifySuccess(string $message, int $duration = 3000)
    {
        return $this->notify($message, 'success', $duration);
    }

    /**
     * Show an error notification.
     *
     * @param string $message
     * @param int $duration
     * @return $this
     */
    public function notifyError(string $message, int $duration = 3000)
    {
        return $this->notify($message, 'error', $duration);
    }

    /**
     * Show a warning notification.
     *
     * @param string $message
     * @param int $duration
     * @return $this
     */
    public function notifyWarning(string $message, int $duration = 3000)
    {
        return $this->notify($message, 'warning', $duration);
    }

    /**
     * Show an info notification.
     *
     * @param string $message
     * @param int $duration
     * @return $this
     */
    public function notifyInfo(string $message, int $duration = 3000)
    {
        return $this->notify($message, 'info', $duration);
    }
} 