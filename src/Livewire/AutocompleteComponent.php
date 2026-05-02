<?php

namespace Zakarialabib\BComponents\Livewire;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;

class AutocompleteComponent extends BaseComponent
{
    /**
     * The search query.
     *
     * @var string
     */
    public $query = '';

    /**
     * The selected item.
     *
     * @var mixed
     */
    public $selected = null;

    /**
     * The search results.
     *
     * @var Collection
     */
    public $results;

    /**
     * The data source for the autocomplete.
     *
     * @var array|Collection
     */
    public $dataSource = [];

    /**
     * The minimum number of characters to trigger the search.
     *
     * @var int
     */
    public $minCharacters = 2;

    /**
     * The debounce time in milliseconds.
     *
     * @var int
     */
    public $debounce = 300;

    /**
     * The maximum number of results to display.
     *
     * @var int
     */
    public $maxResults = 10;

    /**
     * The field to display in the results.
     *
     * @var string
     */
    public $displayField = 'name';

    /**
     * The field to use as the value.
     *
     * @var string
     */
    public $valueField = 'id';

    /**
     * Whether to use a remote data source.
     *
     * @var bool
     */
    public $remote = false;

    /**
     * The URL for the remote data source.
     *
     * @var string|null
     */
    public $remoteUrl = null;

    /**
     * The placeholder text.
     *
     * @var string
     */
    public $placeholder = 'Search...';

    /**
     * The listeners for the component.
     *
     * @var array
     */
    protected $listeners = [
        'refresh' => '$refresh',
    ];

    /**
     * Mount the component.
     *
     * @param array|Collection $dataSource
     * @param string $displayField
     * @param string $valueField
     * @param int $minCharacters
     * @param int $debounce
     * @param int $maxResults
     * @param bool $remote
     * @param string|null $remoteUrl
     * @param string $placeholder
     * @return void
     */
    public function mount(
        $dataSource = [],
        $displayField = 'name',
        $valueField = 'id',
        $minCharacters = 2,
        $debounce = 300,
        $maxResults = 10,
        $remote = false,
        $remoteUrl = null,
        $placeholder = 'Search...'
    ) {
        $this->dataSource = $dataSource instanceof Collection ? $dataSource : collect($dataSource);
        $this->displayField = $displayField;
        $this->valueField = $valueField;
        $this->minCharacters = $minCharacters;
        $this->debounce = $debounce;
        $this->maxResults = $maxResults;
        $this->remote = $remote;
        $this->remoteUrl = $remoteUrl;
        $this->placeholder = $placeholder;
        $this->results = collect([]);
    }

    /**
     * Updated query property.
     *
     * @param string $value
     * @return void
     */
    public function updatedQuery($value)
    {
        $this->search();
    }

    /**
     * Search for results based on the query.
     *
     * @return void
     */
    public function search()
    {
        if (strlen($this->query) < $this->minCharacters) {
            $this->results = collect([]);
            return;
        }

        if ($this->remote && $this->remoteUrl) {
            // For remote data sources, we would typically make an API call
            // This would be implemented by the user in their own component
            // that extends this one
            $this->searchRemote();
        } else {
            $this->searchLocal();
        }
    }

    /**
     * Search in the local data source.
     *
     * @return void
     */
    protected function searchLocal()
    {
        $query = strtolower($this->query);
        
        $this->results = $this->dataSource
            ->filter(function ($item) use ($query) {
                $value = data_get($item, $this->displayField);
                return stripos($value, $query) !== false;
            })
            ->take($this->maxResults);
    }

    /**
     * Search in a remote data source.
     * This method should be overridden in a child class to implement
     * specific API calls.
     *
     * @return void
     */
    protected function searchRemote()
    {
        // This is a placeholder method that should be overridden
        // in a child class to implement specific API calls
        $this->results = collect([]);
    }

    /**
     * Select an item from the results.
     *
     * @param mixed $value
     * @return void
     */
    public function selectItem($value)
    {
        $item = $this->results->firstWhere($this->valueField, $value);
        
        if ($item) {
            $this->selected = $item;
            $this->query = data_get($item, $this->displayField);
            $this->results = collect([]);
            $this->emit('itemSelected', $item);
        }
    }

    /**
     * Clear the selection.
     *
     * @return void
     */
    public function clearSelection()
    {
        $this->selected = null;
        $this->query = '';
        $this->results = collect([]);
        $this->emit('selectionCleared');
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return View::make('bcomponents::livewire.autocomplete');
    }
}