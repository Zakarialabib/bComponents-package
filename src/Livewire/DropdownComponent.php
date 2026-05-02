<?php

namespace Zakarialabib\BComponents\Livewire;

use Illuminate\Support\Facades\View;

class DropdownComponent extends BaseComponent
{
    /**
     * The label for the dropdown.
     *
     * @var string
     */
    public $label = '';

    /**
     * The icon for the dropdown.
     *
     * @var string|null
     */
    public $icon = null;

    /**
     * The position of the dropdown menu.
     *
     * @var string
     */
    public $position = 'left';

    /**
     * The width of the dropdown menu.
     *
     * @var string
     */
    public $width = 'w-48';

    /**
     * Whether the dropdown is open.
     *
     * @var bool
     */
    public $isOpen = false;

    /**
     * Mount the component.
     *
     * @param string $label
     * @param string|null $icon
     * @param string $position
     * @param string $width
     * @return void
     */
    public function mount($label = '', $icon = null, $position = 'left', $width = 'w-48')
    {
        $this->label = $label;
        $this->icon = $icon;
        $this->position = $position;
        $this->width = $width;
    }

    /**
     * Toggle the dropdown.
     *
     * @return void
     */
    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }

    /**
     * Close the dropdown.
     *
     * @return void
     */
    public function close()
    {
        $this->isOpen = false;
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return View::make('bcomponents::livewire.dropdown');
    }
} 