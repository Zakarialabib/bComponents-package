# date-picker (Livewire)

## Tag
- `<livewire:b-date-picker />`

## Status
- `supported`

## Public Props
- `mixed $date`
- `mixed $format`
- `mixed $minDate`
- `mixed $maxDate`
- `mixed $enableTime`
- `mixed $enableSeconds`
- `mixed $timeFormat`
- `mixed $placeholder`

## Listeners / Events
- (none detected)

## Dependencies
- Alpine.js
- Flatpickr (bundled)

Requirements:
- Your layout MUST include `<x-b-assets />` so `flatpickr` is available.

## Accessibility
- (no explicit markers detected in view)

## Usage Example

```blade
<x-b-assets />

<livewire:b-date-picker />
```

## Code
- Class: Zakarialabib\BComponents\Livewire\DatePickerComponent
- View: /workspace/resources/views/livewire/date-picker.blade.php
