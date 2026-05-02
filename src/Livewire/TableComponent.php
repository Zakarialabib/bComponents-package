<?php

namespace Zakarialabib\BComponents\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Arr;
use Livewire\WithPagination;

class TableComponent extends BaseComponent
{
    use WithPagination;

    /**
     * The collection of items to display in the table.
     *
     * @var Collection|null
     */
    public $items;

    /**
     * The columns to display in the table.
     *
     * @var array
     */
    public $columns = [];

    /**
     * Whether to show pagination.
     *
     * @var bool
     */
    public $paginate = true;

    /**
     * The number of items to show per page.
     *
     * @var int
     */
    public $perPage = 10;

    /**
     * Whether to show the search input.
     *
     * @var bool
     */
    public $searchable = true;

    /**
     * The search query.
     *
     * @var string
     */
    public $search = '';

    /**
     * The column to sort by.
     *
     * @var string
     */
    public $sortField = 'id';

    /**
     * The direction to sort.
     *
     * @var string
     */
    public $sortDirection = 'asc';

    /**
     * The current page.
     *
     * @var int
     */
    public $page = 1;

    /**
     * Mount the component.
     *
     * @param Collection|array|null $items
     * @param array $columns
     * @param bool $paginate
     * @param int $perPage
     * @param bool $searchable
     * @return void
     */
    public function mount($items = null, $columns = [], $paginate = true, $perPage = 10, $searchable = true)
    {
        $this->items = $items instanceof Collection ? $items : collect($items ?? []);
        $this->columns = $columns;
        $this->paginate = $paginate;
        $this->perPage = $perPage;
        $this->searchable = $searchable;
    }

    /**
     * Sort the table by the given field.
     *
     * @param string $field
     * @return void
     */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    /**
     * Get the filtered and sorted items.
     *
     * @return Collection
     */
    public function getFilteredItemsProperty()
    {
        $items = $this->items;

        if ($this->searchable && $this->search !== '') {
            $items = $items->filter(function ($item) {
                foreach ($this->columns as $column) {
                    $value = data_get($item, $column['field'] ?? $column);
                    if (is_string($value) && stripos($value, $this->search) !== false) {
                        return true;
                    }
                }
                return false;
            });
        }

        if ($this->sortField) {
            $items = $items->sortBy($this->sortField, SORT_REGULAR, $this->sortDirection === 'desc');
        }

        return $items;
    }

    /**
     * Get the paginated items.
     *
     * @return Collection
     */
    public function getPaginatedItemsProperty()
    {
        if (!$this->paginate) {
            return $this->getFilteredItemsProperty();
        }

        $items = $this->getFilteredItemsProperty()->forPage(
            $this->page,
            $this->perPage
        );

        return $items;
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return View::make('bcomponents::livewire.table', [
            'items' => $this->getPaginatedItemsProperty(),
            'total' => $this->getFilteredItemsProperty()->count(),
        ]);
    }
} 