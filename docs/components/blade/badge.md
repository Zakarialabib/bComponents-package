# badge (Blade)

## Tag
- `<x-b-badge>`

## Status
- `stable`

## Constructor (Props)
- No constructor props. Props are read from component attributes (v1-style).

Props:
- `tone` (preferred) / `color` (alias): `primary|secondary|success|danger|warning|info|light|dark`
- `variant`: `solid|outline|soft|dot|pill`
- `size`: `xs|sm|md|lg|xl`
- `isDismissible` (or `dismissible`): shows a dismiss button that removes the badge element client-side
- `isCounter` (or `counter`): renders as a rounded counter pill
- `icon`: CSS class for an icon element (`<i class="...">`)
- `iconPosition`: `left|right`
- `isIconOnly` (or `iconOnly`): renders sr-only text for screen readers
- `href`: renders the badge as a link when present
- `title`: sets the `title` attribute on the badge

## Slots
- `default`

## Dependencies
- (none)

## Accessibility
- Uses aria-* attributes

## Usage Example

```blade
<x-b-badge tone="success">New</x-b-badge>

<x-b-badge tone="secondary" variant="outline" href="/billing">
    Billing
</x-b-badge>

<x-b-badge tone="primary" :is-counter="true">3</x-b-badge>
```

## Code
- Class: Zakarialabib\BComponents\Components\BadgeComponent
- View: /workspace/resources/views/components/badge.blade.php
