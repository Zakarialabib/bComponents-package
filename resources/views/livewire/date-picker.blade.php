<div
    x-data="{
        init() {
            const flatpickrFn = window.flatpickr;
            if (!flatpickrFn) return;

            const flatpickrInstance = flatpickrFn(this.$refs.input, {
                dateFormat: '{{ $format }}',
                defaultDate: '{{ $date }}',
                minDate: '{{ $minDate }}',
                maxDate: '{{ $maxDate }}',
                enableTime: {{ $enableTime ? 'true' : 'false' }},
                enableSeconds: {{ $enableSeconds ? 'true' : 'false' }},
                time_24hr: true,
                timeFormat: '{{ $timeFormat }}',
                onChange: (selectedDates, dateStr) => {
                    @this.updateDate(dateStr);
                }
            });

            this.$watch('date', value => {
                flatpickrInstance.setDate(value);
            });
        }
    }"
    class="relative"
>
    <input
        x-ref="input"
        type="text"
        placeholder="{{ $placeholder }}"
        class="w-full px-3 py-2 border border-[color:var(--b-color-border)] rounded-[var(--b-radius-md)] shadow-sm bg-[color:var(--b-color-surface)] text-[color:var(--b-color-text)] focus:outline-none focus:ring-[color:var(--b-color-primary)] focus:border-[color:var(--b-color-primary)]"
        readonly
    />
</div>
