# breadcrumb (Blade)

## Tag
- `<x-b-breadcrumb>`

## Status
- `stable`

## Constructor (Props)
- `Zakarialabib\BComponents\Components\BreadcrumbComponent(array $items = [], string $separator = "/", bool $showHomeIcon = true)`

Props:
- `items`: Array of breadcrumb items. Each item supports:
  - `label` (string, required)
  - `url` (string|null, optional)
- `separator`: Separator character/string displayed between items.
- `showHomeIcon`: When true, the first item gets a home icon.

## Slots
- (none)

## Dependencies
- (none)

## Accessibility
- Uses aria-* attributes
- Last item renders `aria-current="page"`.

## Usage Example

```blade
<x-b-breadcrumb
    :items="[
        ['label' => 'Home', 'url' => route('home')],
        ['label' => 'Settings', 'url' => route('settings')],
        ['label' => 'Profile', 'url' => null],
    ]"
/>
```

## Code
- Class: Zakarialabib\BComponents\Components\BreadcrumbComponent
- View: /workspace/resources/views/components/breadcrumb.blade.php
