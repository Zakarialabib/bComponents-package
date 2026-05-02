# table (Blade)

## Tag
- `<x-b-table>`

## Status
- `stable`

## Constructor (Props)
- `Zakarialabib\BComponents\Components\TableComponent(array $attributes = [])`

Props are read from component attributes (v1-style). Common props:
- `responsive` (bool): wrap with horizontal scroll (`overflow-x-auto`)
- `striped` (bool)
- `hoverable` (bool)
- `bordered` (bool)
- `compact` (bool)
- `divider` (`none|normal|thick`)

## Slots
- `default`
- `header`
- `footer`

## Dependencies
- (none)

## Accessibility
- (no explicit markers detected in view)

## Usage Example

```blade
<x-b-table :responsive="true">
    <x-slot:header>
        <x-b-table.header>
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-[color:var(--b-color-text-muted)] uppercase tracking-wider">
                    Name
                </th>
            </tr>
        </x-b-table.header>
    </x-slot:header>

    <x-b-table.body>
        <x-b-table.row>
            <x-b-table.cell>John</x-b-table.cell>
        </x-b-table.row>
    </x-b-table.body>
</x-b-table>
```

## Code
- Class: Zakarialabib\BComponents\Components\TableComponent
- View: /workspace/resources/views/components/table/table.blade.php
