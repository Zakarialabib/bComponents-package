# modal (Livewire)

## Tag
- `<livewire:b-modal />`

## Status
- `experimental`

## Public Props
- `mixed $isOpen`
- `mixed $title`
- `mixed $size`
- `mixed $centered`
- `mixed $scrollable`
- `mixed $static`
- `mixed $content`

## Listeners / Events
- `openModal → open`
- `closeModal → close`
- `refresh → $refresh`

## Dependencies
- Alpine.js

## Accessibility
- role="dialog" present
- Uses aria-* attributes
- Keyboard handlers present

## Usage Example

```blade
<livewire:b-modal />
```

## Code
- Class: Zakarialabib\BComponents\Livewire\ModalComponent
- View: /workspace/resources/views/livewire/modal.blade.php
