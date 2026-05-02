<th {{ $attributes->merge(['class' => $classes]) }} scope="col">
    <div class="flex items-center space-x-1">
        <span>{{ $slot }}</span>
        @if($sortable)
            <span class="inline-flex flex-col">
                @if(!$sortDirection || $sortDirection === 'desc')
                    <svg class="w-3 h-3 {{ $sortDirection === 'asc' ? 'text-[color:var(--b-color-text)]' : 'text-[color:var(--b-color-text-muted)]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                    </svg>
                @endif
                @if(!$sortDirection || $sortDirection === 'asc')
                    <svg class="w-3 h-3 {{ $sortDirection === 'desc' ? 'text-[color:var(--b-color-text)]' : 'text-[color:var(--b-color-text-muted)]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                @endif
            </span>
        @endif
    </div>
</th> 
