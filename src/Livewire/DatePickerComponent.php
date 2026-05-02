<?php

namespace Zakarialabib\BComponents\Livewire;

use Illuminate\Support\Facades\View;

class DatePickerComponent extends BaseComponent
{
    /**
     * The selected date.
     *
     * @var string
     */
    public $date = '';

    /**
     * The date format.
     *
     * @var string
     */
    public $format = 'Y-m-d';

    /**
     * The minimum date.
     *
     * @var string|null
     */
    public $minDate = null;

    /**
     * The maximum date.
     *
     * @var string|null
     */
    public $maxDate = null;

    /**
     * Whether to show the time picker.
     *
     * @var bool
     */
    public $enableTime = false;

    /**
     * Whether to show the seconds in the time picker.
     *
     * @var bool
     */
    public $enableSeconds = false;

    /**
     * The time format.
     *
     * @var string
     */
    public $timeFormat = 'H:i';

    /**
     * The placeholder text.
     *
     * @var string
     */
    public $placeholder = 'Select date';

    /**
     * Mount the component.
     *
     * @param string $date
     * @param string $format
     * @param string|null $minDate
     * @param string|null $maxDate
     * @param bool $enableTime
     * @param bool $enableSeconds
     * @param string $timeFormat
     * @param string $placeholder
     * @return void
     */
    public function mount(
        $date = '',
        $format = 'Y-m-d',
        $minDate = null,
        $maxDate = null,
        $enableTime = false,
        $enableSeconds = false,
        $timeFormat = 'H:i',
        $placeholder = 'Select date'
    ) {
        $this->date = $date;
        $this->format = $format;
        $this->minDate = $minDate;
        $this->maxDate = $maxDate;
        $this->enableTime = $enableTime;
        $this->enableSeconds = $enableSeconds;
        $this->timeFormat = $timeFormat;
        $this->placeholder = $placeholder;
    }

    /**
     * Update the date.
     *
     * @param string $date
     * @return void
     */
    public function updateDate($date)
    {
        $this->date = $date;
        $this->emit('dateUpdated', $this->date);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return View::make('bcomponents::livewire.date-picker');
    }
} 