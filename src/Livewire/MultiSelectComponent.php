<?php

namespace Zakarialabib\BComponents\Livewire;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Collection;

class MultiSelectComponent extends BaseComponent
{
    /**
     * The search query.
     *
     * @var string
     */
    public $query = '';

    /**
     * The selected items.
     *
     * @var array
     */
    public $selected = [];

    /**
     * The search results.
     *
     * @var Collection
     */
    public $results;

    /**
     * The data source for the multi-select.
     *
     * @var array|Collection
     */
    public $dataSource = [];

    /**
     * The minimum number of characters to trigger the search.
     *
     * @var int
     */
    public $minCharacters = 1;

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
    public $placeholder = 'Search and select items...';

    /**
     * Whether to allow creating new items.
     *
     * @var bool
     */
    public $allowCreate = false;

    /**
     * The maximum number of items that can be selected.
     *
     * @var int|null
     */
    public $maxItems = null;

    /**
     * The group field for grouping options.
     *
     * @var string|null
     */
    public $groupField = null;

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
     * @param array $selected
     * @param string $displayField
     * @param string $valueField
     * @param int $minCharacters
     * @param int $debounce
     * @param int $maxResults
     * @param bool $remote
     * @param string|null $remoteUrl
     * @param string $placeholder
     * @param bool $allowCreate
     * @param int|null $maxItems
     * @param string|null $groupField
     * @return void
     */
    public function mount(
        $dataSource = [],
        $selected = [],
        $displayField = 'name',
        $valueField = 'id',
        $minCharacters = 1,
        $debounce = 300,
        $maxResults = 10,
        $remote = false,
        $remoteUrl = null,
        $placeholder = 'Search and select items...',
        $allowCreate = false,
        $maxItems = null,
        $groupField = null
    ) {
        $this->dataSource = $dataSource instanceof Collection ? $dataSource : collect($dataSource);
        $this->selected = $selected;
        $this->displayField = $displayField;
        $this->valueField = $valueField;
        $this->minCharacters = $minCharacters;
        $this->debounce = $debounce;
        $this->maxResults = $maxResults;
        $this->remote = $remote;
        $this->remoteUrl = $remoteUrl;
        $this->placeholder = $placeholder;
        $this->allowCreate = $allowCreate;
        $this->maxItems = $maxItems;
        $this->groupField = $groupField;
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
        $selectedValues = collect($this->selected)->pluck($this->valueField)->toArray();
        
        $this->results = $this->dataSource
            ->filter(function ($item) use ($query, $selectedValues) {
                // Skip already selected items
                $value = data_get($item, $this->valueField);
                if (in_array($value, $selectedValues)) {
                    return false;
                }
                
                // Filter by query
                $displayValue = data_get($item, $this->displayField);
                return stripos($displayValue, $query) !== false;
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
        // Check if max items limit is reached
        if ($this->maxItems !== null && count($this->selected) >= $this->maxItems) {
            return;
        }
        
        $item = $this->results->firstWhere($this->valueField, $value);
        
        if ($item) {
            $this->selected[] = $item;
            $this->query = '';
            $this->results = collect([]);
            $this->emit('itemsUpdated', $this->selected);
        }
    }

    /**
     * Create and select a new item.
     *
     * @return void
     */
    public function createItem()
    {
        if (!$this->allowCreate || empty($this->query)) {
            return;
        }
        
        // Check if max items limit is reached
        if ($this->maxItems !== null && count($this->selected) >= $this->maxItems) {
            return;
        }
        
        // Create a new item with the query as the display value
        $item = [
            $this->displayField => $this->query,
            $this->valueField => 'new_' . uniqid(),
        ];
        
        $this->selected[] = $item;
        $this->query = '';
        $this->results = collect([]);
        $this->emit('itemCreated', $item);
        $this->emit('itemsUpdated', $this->selected);
    }

    /**
     * Remove an item from the selection.
     *
     * @param int $index
     * @return void
     */
    public function removeItem($index)
    {
        if (isset($this->selected[$index])) {
            $removed = $this->selected[$index];
            unset($this->selected[$index]);
            $this->selected = array_values($this->selected);
            $this->emit('itemRemoved', $removed);
            $this->emit('itemsUpdated', $this->selected);
        }
    }

    /**
     * Clear all selected items.
     *
     * @return void
     */
    public function clearSelection()
    {
        $this->selected = [];
        $this->query = '';
        $this->results = collect([]);
        $this->emit('selectionCleared');
        $this->emit('itemsUpdated', $this->selected);
    }

    /**
     * Get the grouped results.
     *
     * @return array
     */
    public function getGroupedResults()
    {
        if (!$this->groupField) {
            return [
                null => $this->results->values()->all(),
            ];
        }
        
        return $this->results->groupBy($this->groupField)->toArray();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return View::make('bcomponents::livewire.multi-select');
    }
}