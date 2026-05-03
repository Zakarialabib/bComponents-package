@props([
    'name' => '',
    'title' => '',
    'disabled' => false,
])

<button
    type="button"
    @disabled($disabled)
    x-on:click="setActive('{{ $name }}')"
    x-on:keydown="onKeydown($event)"
    role="tab"
    id="tab-{{ $name }}"
    aria-controls="panel-{{ $name }}"
    :aria-selected="active === '{{ $name }}'"
    :tabindex="active === '{{ $name }}' ? 0 : -1"
    class="order-1 inline-flex items-center px-3 py-2 text-sm border-b-2 border-transparent"
    :class="active === '{{ $name }}' ? 'border-[color:var(--b-color-primary)]' : 'opacity-70 hover:opacity-100'"
>
    {{ $title }}
</button>

<div
    x-cloak
    x-show="active === '{{ $name }}'"
    role="tabpanel"
    id="panel-{{ $name }}"
    aria-labelledby="tab-{{ $name }}"
    class="order-2 w-full pt-4"
    {{ $attributes }}
>
    {{ $slot }}
</div>
