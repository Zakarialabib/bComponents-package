<?php

namespace Zakarialabib\BComponents\Livewire;

use Illuminate\Support\Facades\View;

class ModalComponent extends BaseComponent
{
    /**
     * Whether the modal is open.
     *
     * @var bool
     */
    public $isOpen = false;

    /**
     * The title of the modal.
     *
     * @var string
     */
    public $title = '';

    /**
     * The size of the modal.
     *
     * @var string
     */
    public $size = 'md';

    /**
     * Whether the modal should be centered.
     *
     * @var bool
     */
    public $centered = false;

    /**
     * Whether the modal should be scrollable.
     *
     * @var bool
     */
    public $scrollable = false;

    /**
     * Whether the modal should not close when clicking outside.
     *
     * @var bool
     */
    public $static = false;

    /**
     * The content of the modal.
     *
     * @var string
     */
    public $content = '';

    /**
     * The listeners for the component.
     *
     * @var array
     */
    protected $listeners = [
        'openModal' => 'open',
        'closeModal' => 'close',
        'refresh' => '$refresh',
    ];

    /**
     * Mount the component.
     *
     * @param string $title
     * @param string $size
     * @param bool $centered
     * @param bool $scrollable
     * @param bool $static
     * @param string $content
     * @return void
     */
    public function mount($title = '', $size = 'md', $centered = false, $scrollable = false, $static = false, $content = '')
    {
        $this->title = $title;
        $this->size = $size;
        $this->centered = $centered;
        $this->scrollable = $scrollable;
        $this->static = $static;
        $this->content = $content;
    }

    /**
     * Open the modal.
     *
     * @param array $params
     * @return void
     */
    public function open($params = [])
    {
        foreach ($params as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

        $this->isOpen = true;
    }

    /**
     * Close the modal.
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
        return View::make('bcomponents::livewire.modal');
    }
} 