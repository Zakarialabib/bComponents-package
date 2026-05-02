<div
    x-data="{
        init() {
            const flatpickrInstance = flatpickr(this.$refs.input, {
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
        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
        readonly
    />
</div> 