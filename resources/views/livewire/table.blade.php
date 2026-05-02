<div>
    @if($searchable)
        <div class="mb-4">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search..." 
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
            >
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach($columns as $column)
                        <th 
                            scope="col" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('{{ is_array($column) ? $column['field'] : $column }}')"
                        >
                            @if(is_array($column))
                                {{ $column['label'] ?? ucfirst($column['field']) }}
                            @else
                                {{ ucfirst($column) }}
                            @endif

                            @if($sortField === (is_array($column) ? $column['field'] : $column))
                                @if($sortDirection === 'asc')
                                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                @else
                                    <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                @endif
                            @endif
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($items as $item)
                    <tr>
                        @foreach($columns as $column)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if(is_array($column) && isset($column['render']))
                                    {!! $column['render']($item) !!}
                                @else
                                    {{ data_get($item, is_array($column) ? $column['field'] : $column) }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) }}" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            No items found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($paginate && $total > $perPage)
        <div class="mt-4">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-700">
                    Showing {{ $items->count() }} of {{ $total }} items
                </div>
                <div class="flex space-x-2">
                    <button 
                        wire:click="previousPage" 
                        wire:loading.attr="disabled"
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50"
                        {{ $page <= 1 ? 'disabled' : '' }}
                    >
                        Previous
                    </button>
                    <button 
                        wire:click="nextPage" 
                        wire:loading.attr="disabled"
                        class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50"
                        {{ $page >= ceil($total / $perPage) ? 'disabled' : '' }}
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

