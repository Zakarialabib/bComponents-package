<div
    x-data="{
        query: @entangle('query').live,
        selected: @entangle('selected').live,
        results: @entangle('results').live,
        isOpen: false,
        highlightedIndex: -1,
        init() {
            this.$watch('query', () => {
                this.isOpen = this.results.length > 0;
                this.highlightedIndex = -1;
            });
            
            this.$watch('results', () => {
                this.isOpen = this.results.length > 0;
                this.highlightedIndex = -1;
            });
        },
        selectItem(index) {
            if (this.results[index]) {
                $wire.selectItem(this.results[index]['{{ $valueField }}']);
                this.isOpen = false;
            }
        },
        highlightItem(index) {
            this.highlightedIndex = index;
        },
        removeItem(index) {
            $wire.removeItem(index);
        },
        clearSelection() {
            $wire.clearSelection();
        },
        createItem() {
            if (@js($allowCreate) && this.query.length > 0) {
                $wire.createItem();
                this.isOpen = false;
            }
        },
        handleKeyDown(event) {
            if (!this.isOpen) {
                // Enter to create new item when dropdown is closed
                if (event.key === 'Enter' && @js($allowCreate) && this.query.length > 0) {
                    event.preventDefault();
                    this.createItem();
                    return;
                }
                return;
            }
            
            // Arrow down
            if (event.key === 'ArrowDown') {
                event.preventDefault();
                this.highlightedIndex = this.highlightedIndex < this.results.length - 1 ? this.highlightedIndex + 1 : 0;
            }
            // Arrow up
            else if (event.key === 'ArrowUp') {
                event.preventDefault();
                this.highlightedIndex = this.highlightedIndex > 0 ? this.highlightedIndex - 1 : this.results.length - 1;
            }
            // Enter
            else if (event.key === 'Enter' && this.highlightedIndex >= 0) {
                event.preventDefault();
                this.selectItem(this.highlightedIndex);
            }
            // Escape
            else if (event.key === 'Escape') {
                event.preventDefault();
                this.isOpen = false;
            }
        },
        canAddMoreItems() {
            return @js($maxItems) === null || this.selected.length < @js($maxItems);
        }
    }"
    x-init="init()"
    class="relative w-full"
>
    <div class="mb-2">
        <label class="block text-sm font-medium text-gray-700">
            {{ $label ?? '' }}
        </label>
        
        <div class="relative mt-1">
            <!-- Selected items tags -->
            <div class="flex flex-wrap gap-2 p-2 bg-white border border-gray-300 rounded-md" 
                :class="{'ring-1 ring-indigo-500': isOpen}">
                
                <!-- Tags for selected items -->
                <template x-for="(item, index) in selected" :key="index">
                    <div class="flex items-center bg-indigo-100 text-indigo-800 rounded-md px-2 py-1 text-sm">
                        <span x-text="item['{{ $displayField }}']" class="mr-1"></span>
                        <button 
                            type="button" 
                            class="text-indigo-500 hover:text-indigo-700 focus:outline-none"
                            x-on:click.stop="removeItem(index)"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>
                
                <!-- Input field -->
                <div class="flex-1 min-w-[8rem]" x-show="canAddMoreItems()">
                    <input
                        type="text"
                        class="w-full border-0 p-0 focus:ring-0 text-sm"
                        placeholder="{{ $placeholder }}"
                        x-model.debounce.{{ $debounce }}ms="query"
                        x-on:keydown="handleKeyDown"
                        x-on:focus="isOpen = results.length > 0"
                        autocomplete="off"
                    >
                </div>
                
                <!-- Max items reached message -->
                <div x-show="!canAddMoreItems()" class="text-sm text-gray-500">
                    Maximum of {{ $maxItems }} items selected
                </div>
                
                <!-- Clear button -->
                <button 
                    x-show="selected.length > 0"
                    x-on:click="clearSelection"
                    type="button"
                    class="ml-auto text-gray-400 hover:text-gray-500 focus:outline-none"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
            
            <!-- Results dropdown -->
            <div 
                x-show="isOpen"
                x-on:click.away="isOpen = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="absolute z-10 mt-1 w-full rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                role="listbox"
            >
                <ul class="max-h-60 overflow-auto py-1 text-base sm:text-sm" role="listbox">
                    @if($groupField)
                        @foreach($this->getGroupedResults() as $group => $items)
                            @if($group !== null)
                                <li class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    {{ $group }}
                                </li>
                            @endif
                            
                            @foreach($items as $index => $item)
                                <li
                                    x-on:click="selectItem({{ $index }})"
                                    x-on:mouseenter="highlightItem({{ $index }})"
                                    x-bind:class="{'bg-indigo-600 text-white': highlightedIndex === {{ $index }}, 'text-gray-900': highlightedIndex !== {{ $index }}}"
                                    class="relative cursor-pointer select-none py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white"
                                    role="option"
                                >
                                    <span class="block truncate">{{ $item[$displayField] }}</span>
                                </li>
                            @endforeach
                        @endforeach
                    @else
                        <template x-for="(item, index) in results" :key="index">
                            <li
                                x-on:click="selectItem(index)"
                                x-on:mouseenter="highlightItem(index)"
                                x-bind:class="{'bg-indigo-600 text-white': highlightedIndex === index, 'text-gray-900': highlightedIndex !== index}"
                                class="relative cursor-pointer select-none py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white"
                                role="option"
                            >
                                <span x-text="item['{{ $displayField }}']" class="block truncate"></span>
                            </li>
                        </template>
                    @endif
                    
                    <!-- Create new item option -->
                    <li 
                        x-show="@js($allowCreate) && query.length > 0 && results.length === 0"
                        x-on:click="createItem()"
                        class="relative cursor-pointer select-none py-2 pl-3 pr-9 text-indigo-600 hover:bg-indigo-600 hover:text-white"
                    >
                        Create "<span x-text="query"></span>"
                    </li>
                    
                    <!-- Empty state -->
                    <li 
                        x-show="results.length === 0 && query.length >= {{ $minCharacters }} && !@js($allowCreate)"
                        class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-500"
                    >
                        No results found.
                    </li>
                </ul>
            </div>
        </div>
        
        @error('selected')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>