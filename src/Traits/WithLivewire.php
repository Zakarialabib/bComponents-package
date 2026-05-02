<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Traits;

trait WithLivewire
{
    /**
     * The component's Livewire listeners.
     *
     * @var array
     */
    protected array $livewireListeners = ['refresh' => '$refresh'];

    /**
     * Initialize the Livewire component.
     *
     * @return void
     */
    public function initializeWithLivewire(): void
    {
        $this->listeners = array_merge($this->listeners ?? [], $this->livewireListeners);
    }

    /**
     * Get the Livewire listeners.
     *
     * @return array
     */
    public function getListeners(): array
    {
        return array_merge($this->listeners ?? [], $this->livewireListeners);
    }

    /**
     * Add a Livewire listener.
     *
     * @param string $event
     * @param mixed $handler
     * @return $this
     */
    public function addLivewireListener(string $event, $handler)
    {
        $this->livewireListeners[$event] = $handler;
        
        return $this;
    }

    /**
     * Remove a Livewire listener.
     *
     * @param string $event
     * @return $this
     */
    public function removeLivewireListener(string $event)
    {
        unset($this->livewireListeners[$event]);
        
        return $this;
    }

    

    /**
     * For backward compatibility with Livewire v2.
     * 
     * @param string $event
     * @param mixed ...$params
     * @return $this
     * @deprecated Use dispatch() instead
     */
    public function emit(string $event, ...$params)
    {
        return $this->dispatch($event, ...$params);
    }

    /**
     * For backward compatibility with Livewire v2.
     * 
     * @param string $event
     * @param mixed ...$params
     * @return $this
     * @deprecated Use dispatchTo() instead
     */
    public function emitTo(string $event, ...$params)
    {
        return $this->dispatchTo($event, ...$params);
    }

    /**
     * For backward compatibility with Livewire v2.
     * 
     * @param string $event
     * @param mixed ...$params
     * @return $this
     * @deprecated Use dispatchSelf() instead
     */
    public function emitSelf(string $event, ...$params)
    {
        return $this->dispatchSelf($event, ...$params);
    }

    /**
     * For backward compatibility with Livewire v2.
     * 
     * @param string $event
     * @param mixed ...$params
     * @return $this
     * @deprecated Use dispatchUp() instead
     */
    public function emitUp(string $event, ...$params)
    {
        return $this->dispatchUp($event, ...$params);
    }
}
