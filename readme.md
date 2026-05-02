# BComponents

A modern Laravel Blade component library with Livewire v3 and Alpine.js integration, styled with TailwindCSS.

## Features

- 🚀 Built for Laravel 11+ and Livewire 3/4
- 🎨 Styled with TailwindCSS
- ⚡ Alpine.js for lightweight interactivity
- ♿ Accessible components with ARIA support
- 📱 Fully responsive
- 🔧 Highly customizable
- ⚡ Blade-first, Livewire-friendly

## Architecture

See [docs/architecture/bcomponents-conceptual-architecture.md](docs/architecture/bcomponents-conceptual-architecture.md).

## Requirements

- PHP 8.2+
- Laravel 11+
- Livewire 3.0+ or 4.0+
- TailwindCSS 4.0+
- Alpine.js 3.0+

## Status & Stability

This package is currently in a foundation/stabilization stage: the architecture is converging on a single v1 contract (tokens + recipes + registry), but not every component has been fully migrated to the same styling or API conventions.

Stable (v1-style, actively tested):
- Blade components: `button`, `input`, `textarea`, `select`, `checkbox`, `radio`, `toggle`, `badge`, `alert`, `card`, `modal`, `dropdown`, `tabs`, `table` (and table subcomponents), `select-dropdown`
- Recipes: button/input/surface
- Theme tokens: CSS variables + Tailwind v4 arbitrary values
- Automated tests: Blade render smoke tests + Livewire render smoke tests

Legacy/less normalized (works, but not yet v1-tokenized everywhere):
- `header` / `footer` (documented separately, uses Tailwind color class inputs like `bgColor`, `textColor`)

Experimental:
- Livewire components are shipped and registered, but some require extra frontend libraries (see Livewire section).

## Installation

1. Install via Composer:

```bash
composer require zakarialabib/bcomponents
```

2. Publish the assets (optional):

```bash
php artisan vendor:publish --tag=bcomponents-config
php artisan vendor:publish --tag=bcomponents-views
php artisan vendor:publish --tag=bcomponents-assets
```

3. Include the published CSS/JS (optional):

```blade
<x-b-assets />
```

4. Add the TailwindCSS configuration to your `tailwind.config.js` file:

```js
module.exports = {
    content: [
        // ...
        './vendor/zakarialabib/bcomponents/resources/views/**/*.blade.php',
    ],
    // ...
}
```

## Usage

### Basic Components

BComponents provides a set of ready-to-use Blade components that you can use in your Laravel application. All components are prefixed with `b-` by default (configurable in the config file).

### Component Catalog

The full component catalog (all Blade + Livewire components, with props/slots/a11y/dependencies and copy/paste examples) lives under:
- `docs/components/index.md`

#### Alert Component

```blade
<x-b-alert type="success" dismissible>
    This is a success alert.
</x-b-alert>
```

Props:
- `type`: `info`, `success`, `warning`, `danger`, `error`.
- `dismissible`: Whether the alert can be dismissed.
- `title`: Optional title.
- `icon`: Optional icon identifier (string).

#### Button Component

```blade
<x-b-button type="submit" tone="primary" variant="solid" size="md">
    Submit
</x-b-button>
```

Props:
- `type`: The type of button (`button`, `submit`, `reset`).
- `tone`: The semantic tone (`primary`, ...).
- `variant`: The style variant (`solid`, `outline`, `ghost`, `link`).
- `size`: The size (`sm`, `md`, `lg`).
- `icon`: The icon to display in the button.
- `iconPosition`: The position of the icon (`left`, `right`).
- `href`: If provided, the button will be rendered as an anchor tag.
- `disabled`: Whether the button is disabled.
- `fullWidth`: Whether the button should take up the full width of its container.
- `loading`: Whether the button is in a loading state.
- `loadingText`: The text to display when the button is loading.
- `wire:click`: The Livewire action to call when the button is clicked.
- `x-on:click`: The Alpine.js action to call when the button is clicked.

Legacy props (deprecated):
- `color` (alias of `tone`)
- `isDisabled` (alias of `disabled`)
- `isLoading` (alias of `loading`)
- `isBlock` (alias of `fullWidth`)
- `isIconOnly` (alias of `iconOnly`)

For now these aliases still work as a migration bridge, but they are not considered the stable public API and will be removed in a future major release.

Form controls:
- `Checkbox`, `Radio`, and `Toggle` historically used `color`; use `tone` going forward (the old `color` prop is deprecated).

#### Card Component

```blade
<x-b-card title="Card Title" :show-footer="true">
    This is the card content.

    <x-slot:footer>
        Card Footer
    </x-slot:footer>
</x-b-card>
```

Props:
- `title`: The title of the card.
- `subtitle`: The subtitle of the card.
- `showHeader`: Whether to show the header (default `true`).
- `showFooter`: Whether to render the footer slot (default `false`).

Slots:
- `default`: Card body content.
- `header`: Optional right-side header content.
- `footer`: Footer content (only rendered when `showFooter` is true).

#### Input Component

```blade
<x-b-form-group name="email" label="Email Address" required>
    <x-b-input
        name="email"
        type="email"
        placeholder="Enter your email"
        required
    />
</x-b-form-group>
```

Props:
- `name`: The name of the input.
- `id`: The ID of the input.
- `type`: The type of input (`text`, `email`, `password`, `number`, etc.).
- `value`: The value of the input.
- `placeholder`: The placeholder text.
- `required`: Whether the input is required.
- `disabled`: Whether the input is disabled.
- `readonly`: Whether the input is readonly.
- `autofocus`: Whether the input should autofocus.
- `invalid`: Whether the input should render in an invalid state.
- `size`: Input size (`sm`, `md`, `lg`).
- `prefix`/`suffix`: Optional text addons.
- `prefixIcon`/`suffixIcon`: Optional icon identifiers (string).

#### Dropdown Component

```blade
<x-b-dropdown align="left" width="md">
    <x-slot:trigger>
        <x-b-button type="button" tone="secondary">Dropdown</x-b-button>
    </x-slot:trigger>

    <x-slot:content>
        <a href="#" class="block px-4 py-2 text-sm">Item 1</a>
        <a href="#" class="block px-4 py-2 text-sm">Item 2</a>
        <a href="#" class="block px-4 py-2 text-sm">Item 3</a>
    </x-slot:content>
</x-b-dropdown>
```

Props:
- `align`: Menu alignment (`left`, `right`).
- `width`: Menu width (`sm`, `md`, `lg`).

Slots:
- `trigger`: The clickable trigger.
- `content`: The menu content.

#### Modal Component

```blade
<x-b-modal name="my-modal" title="Modal Title">
    <p>This is the modal content.</p>
    
    <x-slot:footer>
        <x-b-button
            tone="secondary"
            type="button"
            x-on:click="$dispatch('close-modal', 'my-modal')"
        >
            Close
        </x-b-button>
        <x-b-button tone="primary">Save changes</x-b-button>
    </x-slot>
</x-b-modal>

<x-b-button type="button" x-on:click="$dispatch('open-modal', 'my-modal')">
    Open Modal
</x-b-button>
```

Props:
- `name`: The modal name (used by the open/close browser events).
- `title`: The title of the modal.
- `maxWidth`: The max width (`sm`, `md`, `lg`, `xl`, `2xl`, `3xl`, `4xl`, `5xl`, `6xl`, `7xl`, `full`).
- `show`: Whether the modal starts open.
- `centered`: Whether the modal should be vertically centered.
- `scrollable`: Whether the modal should be scrollable.
- `static`: Whether the modal should not close when clicking outside.

### Livewire Components (Experimental)

The package ships a set of Livewire components and registers them automatically when `bcomponents.livewire.enabled=true`. Their tag names use the same prefix as Blade components.

Default prefix `b` yields tags:
- `<livewire:b-table />`
- `<livewire:b-modal />`
- `<livewire:b-dropdown />`
- `<livewire:b-tabs />`
- `<livewire:b-date-picker />`
- `<livewire:b-autocomplete />`
- `<livewire:b-multi-select />`
- `<livewire:b-file-upload />`
- `<livewire:b-rich-text-editor />`

#### Livewire Table

```blade
<livewire:b-table
    :items="$users"
    :columns="[
        ['field' => 'id', 'label' => 'ID'],
        ['field' => 'name', 'label' => 'Name'],
        ['field' => 'email', 'label' => 'Email'],
    ]"
    :paginate="true"
    :per-page="10"
    :searchable="true"
/>
```

#### Livewire Modal

```blade
<livewire:b-modal title="Modal Title" size="md" :static="false" />
```

Events:
- `openModal` / `closeModal`

#### Livewire Date Picker

```blade
<livewire:b-date-picker date="2026-01-01" format="Y-m-d" />
```

External dependency: requires `flatpickr` loaded on the page.

#### Livewire Rich Text Editor

```blade
<livewire:b-rich-text-editor />
```

External dependency: loads CKEditor from CDN by default in the shipped view.

If you want a Blade-first experience with no extra JS libraries, prefer the Blade components section and use Livewire only for components that are intentionally Livewire-centric.

## View Overrides

To override a component view, publish views and edit the published template:

```bash
php artisan vendor:publish --tag=bcomponents-views
```

Then edit files under `resources/views/vendor/bcomponents/...`.

## Configuration

You can customize the components by editing the configuration file located at `config/bcomponents.php`.

```php
return [
    'prefix' => 'b',

    'theme' => [
        'preset' => 'default',
        'dark_mode' => true,
        'tokens_path' => null,
    ],

    'components' => [
        'enabled' => [],
    ],

    'assets' => [
        'include_css' => true,
        'include_js' => true,
    ],

    'livewire' => [
        'enabled' => true,
        'compatibility_mode' => 'auto',
    ],

    'docs' => [
        'metadata' => true,
    ],
];
```

Breaking changes:
- `default_classes` removed
- `css_framework` removed (Tailwind only)

## Performance Notes

This package is primarily Blade-first; runtime performance is mostly determined by your application and Tailwind build settings. A few practical notes:
- Blade components are regular Laravel components; they do not add runtime overhead beyond view rendering and class computation.
- Livewire components behave like normal Livewire components; request frequency and DOM updates are controlled by your bindings (debounce, lazy, etc.).
- Alpine-powered interactions (dropdown/modal/tabs) run client-side and avoid server roundtrips for open/close UI state.

## Contributing

Contributions are welcome. Start with [instructions.md](file:///workspace/instructions.md) (tests, phpstan, architecture conventions), then open a PR.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).
