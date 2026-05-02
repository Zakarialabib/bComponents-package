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
        clearSelection() {
            $wire.clearSelection();
        },
        handleKeyDown(event) {
            if (!this.isOpen) return;
            
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
            <input
                type="text"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="{{ $placeholder }}"
                x-model.debounce.{{ $debounce }}ms="query"
                x-on:keydown="handleKeyDown"
                x-on:focus="isOpen = results.length > 0"
                x-on:click.away="isOpen = false"
                autocomplete="off"
            >
            
            <!-- Clear button -->
            <button 
                x-show="selected !== null"
                x-on:click="clearSelection"
                type="button"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-500"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <!-- Results dropdown -->
            <div 
                x-show="isOpen"
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
                    <template x-for="(item, index) in results" :key="index">
                        <li
                            x-on:click="selectItem(index)"
                            x-on:mouseenter="highlightItem(index)"
                            x-bind:class="{'bg-indigo-600 text-white': highlightedIndex === index, 'text-gray-900': highlightedIndex !== index}"
                            class="relative cursor-pointer select-none py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white"
                            role="option"
                        >
                            <span x-text="item['{{ $displayField }}']" class="block truncate"></span>
                            
                            <!-- Selected indicator -->
                            <span 
                                x-show="selected !== null && selected['{{ $valueField }}'] === item['{{ $valueField }}']"
                                class="absolute inset-y-0 right-0 flex items-center pr-4"
                                x-bind:class="{'text-white': highlightedIndex === index, 'text-indigo-600': highlightedIndex !== index}"
                            >
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </li>
                    </template>
                    
                    <!-- Empty state -->
                    <li 
                        x-show="results.length === 0 && query.length >= {{ $minCharacters }}"
                        class="relative cursor-default select-none py-2 pl-3 pr-9 text-gray-500"
                    >
                        No results found.
                    </li>
                </ul>
            </div>
        </div>
        
        @error('query')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>