@props([
    'striped' => false,
    'hoverable' => true,
    'bordered' => false,
    'compact' => false,
])

<div {{ $attributes->merge(['class' => $classes]) }}>
    <table class="{{ $classes }}">
        @if(isset($header))
            <thead class="bg-gray-50">
                {{ $header }}
            </thead>
        @endif

        <tbody class="bg-white divide-y divide-gray-200">
            {{ $slot }}
        </tbody>

        @if(isset($footer))
            <tfoot class="bg-gray-50">
                {{ $footer }}
            </tfoot>
        @endif
    </table>
</div> 