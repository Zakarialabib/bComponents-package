<?php

namespace Zakarialabib\BComponents\Livewire;

use Illuminate\Support\Facades\View;

class RichTextEditorComponent extends BaseComponent
{
    /**
     * The content of the editor.
     *
     * @var string
     */
    public $content = '';

    /**
     * The editor configuration options.
     *
     * @var array
     */
    public $config = [];

    /**
     * The editor height.
     *
     * @var string
     */
    public $height = '300px';

    /**
     * The editor placeholder.
     *
     * @var string
     */
    public $placeholder = 'Start typing...';

    /**
     * Whether the editor is in read-only mode.
     *
     * @var bool
     */
    public $readOnly = false;

    /**
     * The toolbar configuration.
     *
     * @var array
     */
    public $toolbar = [
        'heading',
        'bold',
        'italic',
        'link',
        'bulletedList',
        'numberedList',
        'blockQuote',
        'insertTable',
        'imageUpload',
        'undo',
        'redo'
    ];

    /**
     * The listeners for the component.
     *
     * @var array
     */
    protected $listeners = [
        'contentUpdated' => 'updateContent',
        'refresh' => '$refresh',
    ];

    /**
     * Mount the component.
     *
     * @param string $content
     * @param array $config
     * @param string $height
     * @param string $placeholder
     * @param bool $readOnly
     * @param array $toolbar
     * @return void
     */
    public function mount($content = '', $config = [], $height = '300px', $placeholder = 'Start typing...', $readOnly = false, $toolbar = null)
    {
        $this->content = $content;
        $this->config = $config;
        $this->height = $height;
        $this->placeholder = $placeholder;
        $this->readOnly = $readOnly;
        
        if ($toolbar !== null) {
            $this->toolbar = $toolbar;
        }
    }

    /**
     * Update the editor content.
     *
     * @param string $content
     * @return void
     */
    public function updateContent($content)
    {
        $this->content = $content;
        $this->emit('contentChanged', $this->content);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return View::make('bcomponents::livewire.rich-text-editor');
    }
}