# drawer (Blade)

## Tag
- `<x-b-drawer>`

## Status
- `stable`

## Constructor (Props)
- `Zakarialabib\BComponents\Components\DrawerComponent(string $name = "", bool $show = false, string $position = "right", string $width = "md", bool $static = false, ?string $title = null)`

Props:
- `name`: Drawer identifier (required for open/close events)
- `show`: Starts open when true
- `position`: `left|right`
- `width`: `sm|md|lg`
- `static`: When true, clicking overlay / Escape will not close
- `title`: Optional title string

## Slots
- `default`
- `footer`

## Dependencies
- Alpine.js

## Accessibility
- Uses aria-* attributes
- Keyboard handlers present

## Usage Example

```blade
<x-b-drawer name="settings" title="Settings">
    Drawer content

    <x-slot:footer>
        <x-b-button type="button" tone="secondary" x-on:click="$dispatch('close-drawer', 'settings')">
            Close
        </x-b-button>
    </x-slot:footer>
</x-b-drawer>

<x-b-button type="button" x-on:click="$dispatch('open-drawer', 'settings')">
    Open drawer
</x-b-button>
```

## Code
- Class: Zakarialabib\BComponents\Components\DrawerComponent
- View: /workspace/resources/views/components/drawer.blade.php
