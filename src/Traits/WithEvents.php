<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait WithEvents
{
    /**
     * The component's events.
     *
     * @var array
     */
    protected array $events = [];

    /**
     * The component's event listeners.
     *
     * @var array
     */
    protected array $eventListeners = [];

    /**
     * Initialize the component's events.
     *
     * @return void
     */
    protected function initializeEvents(): void
    {
        foreach ($this->events as $event => $handler) {
            $this->addEventListener($event, $handler);
        }
    }

    /**
     * Add an event listener.
     *
     * @param string $event
     * @param mixed $handler
     * @return $this
     */
    public function addEventListener(string $event, $handler)
    {
        $this->eventListeners[$event] = $handler;
        
        return $this;
    }

    /**
     * Remove an event listener.
     *
     * @param string $event
     * @return $this
     */
    public function removeEventListener(string $event)
    {
        unset($this->eventListeners[$event]);
        
        return $this;
    }

    /**
     * Determine if the component has an event listener.
     *
     * @param string $event
     * @return bool
     */
    public function hasEventListener(string $event): bool
    {
        return isset($this->eventListeners[$event]);
    }

    /**
     * Get the component's event listeners.
     *
     * @param string|null $event
     * @return mixed
     */
    public function getEventListeners(?string $event = null)
    {
        return $event 
            ? ($this->eventListeners[$event] ?? null) 
            : $this->eventListeners;
    }

    /**
     * Dispatch an event.
     *
     * @param string $event
     * @param mixed $payload
     * @return mixed
     */
    public function dispatchEvent(string $event, $payload = null)
    {
        $handler = $this->getEventListeners($event);
        
        if ($handler) {
            if (is_callable($handler)) {
                return $handler($payload);
            }
            
            if (is_string($handler) && method_exists($this, $handler)) {
                return $this->{$handler}($payload);
            }
        }
        
        return null;
    }

    /**
     * Get the component's event attributes.
     *
     * @return array
     */
    protected function getEventAttributes(): array
    {
        $attributes = [];
        
        foreach ($this->eventListeners as $event => $handler) {
            if (Str::startsWith($event, 'on')) {
                $attributes[$event] = $handler;
            } else {
                $attributes['on' . ucfirst($event)] = $handler;
            }
        }
        
        return $attributes;
    }

    /**
     * Get the component's Livewire event attributes.
     *
     * @return array
     */
    protected function getLivewireEventAttributes(): array
    {
        $attributes = [];
        
        foreach ($this->eventListeners as $event => $handler) {
            if (is_string($handler)) {
                $attributes['wire:' . $event] = $handler;
            }
        }
        
        return $attributes;
    }

    /**
     * Get the component's Alpine.js event attributes.
     *
     * @return array
     */
    protected function getAlpineEventAttributes(): array
    {
        $attributes = [];
        
        foreach ($this->eventListeners as $event => $handler) {
            if (is_string($handler)) {
                $attributes['x-on:' . $event] = $handler;
            }
        }
        
        return $attributes;
    }
} 