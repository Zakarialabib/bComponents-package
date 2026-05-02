<?php

namespace Zakarialabib\BComponents\Livewire;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;

class TabsComponent extends BaseComponent
{
    /**
     * The tabs.
     *
     * @var array
     */
    public $tabs = [];

    /**
     * The active tab.
     *
     * @var string|int
     */
    public $activeTab;

    /**
     * Mount the component.
     *
     * @param array $tabs
     * @param string|int|null $activeTab
     * @return void
     */
    public function mount($tabs = [], $activeTab = null)
    {
        $this->tabs = $tabs;
        $this->activeTab = $activeTab ?? array_key_first($tabs);
    }

    /**
     * Set the active tab.
     *
     * @param string|int $tab
     * @return void
     */
    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return View::make('bcomponents::livewire.tabs');
    }
} 