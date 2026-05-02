@props([
    'striped' => false,
    'hoverable' => true,
    'bordered' => false,
    'compact' => false,
])

<div {{ $attributes->merge(['class' => $wrapperClasses ?? '']) }}>
    <table class="{{ $classes }}">
        @if(isset($header))
            <thead class="bg-[color:var(--b-color-surface-muted)]">
                {{ $header }}
            </thead>
        @endif

        <tbody class="bg-[color:var(--b-color-surface)] divide-y divide-[color:var(--b-color-border)]">
            {{ $slot }}
        </tbody>

        @if(isset($footer))
            <tfoot class="bg-[color:var(--b-color-surface-muted)]">
                {{ $footer }}
            </tfoot>
        @endif
    </table>
</div> 
