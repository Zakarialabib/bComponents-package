# BComponents

A modern Laravel Blade component library with Livewire v3 and Alpine.js integration, styled with TailwindCSS.

## Features

- 🚀 Built for Laravel 11+ and Livewire 3.0+
- 🎨 Styled with TailwindCSS
- ⚡ Alpine.js for lightweight interactivity
- ♿ Accessible components with ARIA support
- 📱 Fully responsive
- 🔧 Highly customizable
- ⚡ Performance optimized for Livewire v3

## Architecture

See [docs/architecture/bcomponents-conceptual-architecture.md](docs/architecture/bcomponents-conceptual-architecture.md).

## Requirements

- PHP 8.2+
- Laravel 11+
- Livewire 3.0+ or 4.0+
- TailwindCSS 4.0+
- Alpine.js 3.0+

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
        './vendor/zakarialabib/bcomponents/src/resources/views/**/*.blade.php',
    ],
    // ...
}
```

## Usage

### Basic Components

BComponents provides a set of ready-to-use Blade components that you can use in your Laravel application. All components are prefixed with `b-` by default (configurable in the config file).

#### Alert Component

```blade
<x-b-alert type="success" dismissible>
    This is a success alert.
</x-b-alert>
```

Props:
- `type`: The type of alert (`success`, `info`, `warning`, `danger`, `primary`, `secondary`).
- `dismissible`: Whether the alert can be dismissed.
- `icon`: The icon to display in the alert.
- `title`: The title of the alert.

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

#### Card Component

```blade
<x-b-card title="Card Title" footer="Card Footer">
    This is the card content.
</x-b-card>
```

Props:
- `title`: The title of the card.
- `subtitle`: The subtitle of the card.
- `footer`: The footer of the card.
- `image`: The URL of an image to display in the card.
- `imageAlt`: The alt text for the image.
- `imagePosition`: The position of the image (`top`, `bottom`).
- `headerClass`: Additional classes for the card header.
- `bodyClass`: Additional classes for the card body.
- `footerClass`: Additional classes for the card footer.

#### Input Component

```blade
<x-b-input
    name="email"
    label="Email Address"
    type="email"
    placeholder="Enter your email"
    required
/>
```

Props:
- `name`: The name of the input.
- `id`: The ID of the input (defaults to the name).
- `type`: The type of input (`text`, `email`, `password`, `number`, etc.).
- `label`: The label for the input.
- `value`: The value of the input.
- `placeholder`: The placeholder text.
- `required`: Whether the input is required.
- `disabled`: Whether the input is disabled.
- `readonly`: Whether the input is readonly.
- `autocomplete`: The autocomplete attribute.
- `help`: Help text to display below the input.
- `error`: Error message to display.

#### Dropdown Component

```blade
<x-b-dropdown label="Dropdown">
    <x-b-dropdown-item href="#">Item 1</x-b-dropdown-item>
    <x-b-dropdown-item href="#">Item 2</x-b-dropdown-item>
    <x-b-dropdown-item href="#">Item 3</x-b-dropdown-item>
</x-b-dropdown>
```

Props:
- `label`: The label for the dropdown.
- `icon`: The icon to display in the dropdown.
- `position`: The position of the dropdown menu (`left`, `right`).
- `width`: The width of the dropdown menu.

#### Modal Component

```blade
<x-b-modal id="my-modal" title="Modal Title">
    <p>This is the modal content.</p>
    
    <x-slot name="footer">
        <x-b-button tone="secondary" data-dismiss="modal">Close</x-b-button>
        <x-b-button tone="primary">Save changes</x-b-button>
    </x-slot>
</x-b-modal>

<x-b-button data-toggle="modal" data-target="#my-modal">
    Open Modal
</x-b-button>
```

Props:
- `id`: The ID of the modal.
- `title`: The title of the modal.
- `size`: The size of the modal (`sm`, `md`, `lg`, `xl`, `full`).
- `centered`: Whether the modal should be vertically centered.
- `scrollable`: Whether the modal should be scrollable.
- `static`: Whether the modal should not close when clicking outside.

### Livewire Components

BComponents also provides Livewire components that you can use in your Laravel application. These components are optimized for Livewire v3 and provide enhanced interactivity.

#### Table Component

```php
// In your Livewire component
use App\Models\User;

class UserTable extends \Livewire\Component
{
    public function render()
    {
        return view('livewire.user-table', [
            'users' => User::paginate(10),
        ]);
    }
}
```

```blade
<!-- In your Blade view -->
<livewire:livewire-table
    :items="$users"
    :columns="[
        ['field' => 'id', 'label' => 'ID'],
        ['field' => 'name', 'label' => 'Name'],
        ['field' => 'email', 'label' => 'Email'],
        ['field' => 'created_at', 'label' => 'Created At'],
    ]"
    :paginate="true"
    :per-page="10"
    :searchable="true"
/>
```

Props:
- `items`: The collection of items to display in the table.
- `columns`: The columns to display in the table.
- `paginate`: Whether to show pagination.
- `perPage`: The number of items to show per page.
- `searchable`: Whether to show the search input.

#### Modal Component

```blade
<!-- In your Blade view -->
<livewire:livewire-modal
    title="Modal Title"
    size="md"
    :centered="true"
    :scrollable="false"
    :static="false"
/>

<!-- Trigger the modal -->
<x-b-button wire:click="$emit('openModal', { title: 'Dynamic Title' })">
    Open Modal
</x-b-button>
```

Props:
- `title`: The title of the modal.
- `size`: The size of the modal (`sm`, `md`, `lg`, `xl`, `full`).
- `centered`: Whether the modal should be vertically centered.
- `scrollable`: Whether the modal should be scrollable.
- `static`: Whether the modal should not close when clicking outside.
- `content`: The content of the modal (HTML).

Events:
- `openModal`: Open the modal with optional parameters.
- `closeModal`: Close the modal.

#### Dropdown Component

```blade
<!-- In your Blade view -->
<livewire:livewire-dropdown
    label="Dropdown"
    icon="heroicon-o-chevron-down"
    position="left"
    width="w-48"
>
    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Item 1</a>
    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Item 2</a>
    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Item 3</a>
</livewire:livewire-dropdown>
```

Props:
- `label`: The label for the dropdown.
- `icon`: The icon to display in the dropdown.
- `position`: The position of the dropdown menu (`left`, `right`).
- `width`: The width of the dropdown menu.

#### Tabs Component

```blade
<!-- In your Blade view -->
<livewire:livewire-tabs
    :tabs="[
        'tab1' => ['label' => 'Tab 1', 'content' => '<p>Content for Tab 1</p>'],
        'tab2' => ['label' => 'Tab 2', 'content' => '<p>Content for Tab 2</p>'],
        'tab3' => ['label' => 'Tab 3', 'content' => '<p>Content for Tab 3</p>'],
    ]"
    active-tab="tab1"
/>
```

Props:
- `tabs`: The tabs to display.
- `activeTab`: The active tab.

#### Date Picker Component

```blade
<!-- In your Blade view -->
<livewire:livewire-date-picker
    date="2023-01-01"
    format="Y-m-d"
    min-date="2023-01-01"
    max-date="2023-12-31"
    :enable-time="false"
    :enable-seconds="false"
    time-format="H:i"
    placeholder="Select date"
/>
```

Props:
- `date`: The selected date.
- `format`: The date format.
- `minDate`: The minimum date.
- `maxDate`: The maximum date.
- `enableTime`: Whether to show the time picker.
- `enableSeconds`: Whether to show the seconds in the time picker.
- `timeFormat`: The time format.
- `placeholder`: The placeholder text.

Events:
- `dateUpdated`: Emitted when the date is updated.

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

## Performance Optimization

BComponents is optimized for performance with Livewire v3. Here are some of the optimizations:

- **Lazy Loading**: Components are loaded lazily by default, which means they are only loaded when they are needed.
- **Computed Properties**: Livewire components use computed properties to minimize re-renders.
- **Debounced Inputs**: Inputs are debounced to minimize the number of requests sent to the server.
- **Minimized Re-renders**: Components are designed to minimize re-renders by using Alpine.js for client-side interactivity.
- **Efficient DOM Updates**: Livewire v3's morphdom implementation is used for efficient DOM updates.
- **Deferred Loading**: Components can be deferred to load after the initial page load.

## Contributing

Contributions are welcome! Please read the [contributing guidelines](CONTRIBUTING.md) first.

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).
