<div>
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            @foreach($tabs as $key => $tab)
                <button
                    wire:click="setActiveTab('{{ $key }}')"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ $activeTab === $key ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}"
                    aria-current="{{ $activeTab === $key ? 'page' : 'false' }}"
                >
                    @if(is_array($tab) && isset($tab['label']))
                        {{ $tab['label'] }}
                    @else
                        {{ $tab }}
                    @endif
                </button>
            @endforeach
        </nav>
    </div>
    
    <div class="mt-4">
        @foreach($tabs as $key => $tab)
            <div x-data x-show="{{ $activeTab === $key ? 'true' : 'false' }}" x-cloak>
                @if(is_array($tab) && isset($tab['content']))
                    {!! $tab['content'] !!}
                @elseif(isset(${"tab_{$key}_content"}))
                    {{ ${"tab_{$key}_content"} }}
                @endif
            </div>
        @endforeach
    </div>
</div> 