# Header and Footer Components

These components provide customizable header and footer elements for your application with various positioning, styling, and layout options.

## Header Component

The header component provides a flexible top navigation element with support for logo placement, mobile responsiveness, and various styling options.

### Basic Usage

```blade
<x-b-header>
    My Application
</x-b-header>
```

### With Navigation

```blade
<x-b-header>
    <x-slot:navigation>
        <div class="flex space-x-4">
            <a href="/" class="px-3 py-2 rounded-md text-sm font-medium">Home</a>
            <a href="/about" class="px-3 py-2 rounded-md text-sm font-medium">About</a>
            <a href="/contact" class="px-3 py-2 rounded-md text-sm font-medium">Contact</a>
        </div>
    </x-slot:navigation>
    
    My Application
</x-b-header>
```

### With Custom Mobile Navigation

```blade
<x-b-header>
    <x-slot:navigation>
        <div class="flex space-x-4">
            <a href="/" class="px-3 py-2 rounded-md text-sm font-medium">Home</a>
            <a href="/about" class="px-3 py-2 rounded-md text-sm font-medium">About</a>
            <a href="/contact" class="px-3 py-2 rounded-md text-sm font-medium">Contact</a>
        </div>
    </x-slot:navigation>
    
    <x-slot:mobileNavigation>
        <div class="flex flex-col space-y-1">
            <a href="/" class="block px-3 py-2 rounded-md text-base font-medium">Home</a>
            <a href="/about" class="block px-3 py-2 rounded-md text-base font-medium">About</a>
            <a href="/contact" class="block px-3 py-2 rounded-md text-base font-medium">Contact</a>
        </div>
    </x-slot:mobileNavigation>
    
    My Application
</x-b-header>
```

### With Logo

```blade
<x-b-header :logo="'<img src=\''.asset('/img/logo.svg').'\' class=\'h-8 w-auto\' alt=\'Logo\'>'">
    <!-- Content -->
</x-b-header>
```

### Positioned and Styled

```blade
<x-b-header 
    position="sticky" 
    :isFloating="true" 
    logoPosition="center"
    bgColor="blue-600"
    textColor="white"
    :hasShadow="true">
    
    <!-- Content -->
</x-b-header>
```

### Available Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| position | string | 'static' | Position of the header ('static', 'fixed', 'sticky', 'absolute', 'relative') |
| logoPosition | string | 'left' | Position of the logo ('left', 'center', 'right') |
| containerWidth | string | 'container' | Width of the container ('full', 'container', 'screen') |
| logo | string\|null | null | HTML string for custom logo |
| isFloating | boolean | false | Whether the header should float (with rounded corners) |
| hasNav | boolean | true | Whether to show navigation |
| hasShadow | boolean | true | Whether to show shadow |
| isTransparent | boolean | false | Whether the background is transparent |
| bgColor | string | 'white' | Background color (Tailwind color class without the 'bg-' prefix) |
| textColor | string | 'gray-800' | Text color (Tailwind color class without the 'text-' prefix) |
| borderColor | string\|null | null | Border color (Tailwind color class without the 'border-' prefix) |
| hasBorder | boolean | false | Whether to show a bottom border |
| padding | string | 'py-4 px-6' | Padding classes |
| zIndex | string | 'z-50' | Z-index class |
| mobileBreakpoint | string | 'md' | Breakpoint for mobile menu (e.g., 'md' for medium screens and up) |
| isMobileOpen | boolean | false | Whether the mobile menu is open by default |

## Footer Component

The footer component provides a flexible footer element with support for columns, logo placement, social icons, and various styling options.

### Basic Usage

```blade
<x-b-footer>
    My Application
</x-b-footer>
```

### With Navigation

```blade
<x-b-footer>
    <x-slot:navigation>
        <div class="flex space-x-4">
            <a href="/privacy" class="text-sm">Privacy Policy</a>
            <a href="/terms" class="text-sm">Terms of Service</a>
            <a href="/contact" class="text-sm">Contact Us</a>
        </div>
    </x-slot:navigation>
    
    My Application
</x-b-footer>
```

### With Columns

```blade
<x-b-footer :columnCount="3">
    <x-slot:columns>
        <div>
            <h3 class="text-lg font-bold mb-4">About Us</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
        </div>
        <div>
            <h3 class="text-lg font-bold mb-4">Links</h3>
            <ul class="space-y-2">
                <li><a href="/">Home</a></li>
                <li><a href="/about">About</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>
        </div>
        <div>
            <h3 class="text-lg font-bold mb-4">Contact</h3>
            <address class="not-italic">
                123 Main St<br>
                Anytown, ST 12345<br>
                <a href="mailto:info@example.com">info@example.com</a>
            </address>
        </div>
    </x-slot:columns>
    
    <x-slot:navigation>
        <div class="flex space-x-4">
            <a href="/privacy" class="text-sm">Privacy</a>
            <a href="/terms" class="text-sm">Terms</a>
        </div>
    </x-slot:navigation>
    
    My Application
</x-b-footer>
```

### With Social Icons

```blade
<x-b-footer 
    :hasSocialIcons="true" 
    :socialLinks="[
        ['name' => 'Facebook', 'url' => 'https://facebook.com', 'icon' => 'heroicon-o-globe-alt'],
        ['name' => 'Twitter', 'url' => 'https://twitter.com', 'icon' => 'heroicon-o-globe-alt'],
        ['name' => 'Instagram', 'url' => 'https://instagram.com', 'icon' => 'heroicon-o-globe-alt'],
    ]">
    
    My Application
</x-b-footer>
```

### With Copyright

```blade
<x-b-footer :copyright="'&copy; ' . date('Y') . ' My Company. All rights reserved.'">
    My Application
</x-b-footer>
```

### Positioned and Styled

```blade
<x-b-footer 
    position="sticky" 
    :isFloating="true" 
    logoPosition="center"
    bgColor="gray-900"
    textColor="gray-100"
    :hasShadow="true"
    :copyright="'&copy; ' . date('Y') . ' My Company. All rights reserved.'">
    
    <!-- Content -->
</x-b-footer>
```

### Available Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| position | string | 'static' | Position of the footer ('static', 'fixed', 'sticky', 'absolute', 'relative') |
| logoPosition | string | 'left' | Position of the logo ('left', 'center', 'right') |
| containerWidth | string | 'container' | Width of the container ('full', 'container', 'screen') |
| logo | string\|null | null | HTML string for custom logo |
| isFloating | boolean | false | Whether the footer should float (with rounded corners) |
| hasNav | boolean | true | Whether to show navigation |
| hasShadow | boolean | false | Whether to show shadow |
| isTransparent | boolean | false | Whether the background is transparent |
| bgColor | string | 'gray-800' | Background color (Tailwind color class without the 'bg-' prefix) |
| textColor | string | 'white' | Text color (Tailwind color class without the 'text-' prefix) |
| borderColor | string\|null | null | Border color (Tailwind color class without the 'border-' prefix) |
| hasBorder | boolean | false | Whether to show a top border |
| padding | string | 'py-8 px-6' | Padding classes |
| zIndex | string | 'z-40' | Z-index class |
| copyright | string\|null | null | Copyright text (supports HTML) |
| hasSocialIcons | boolean | false | Whether to show social icons |
| socialLinks | array | [] | Array of social links (each with 'name', 'url', and 'icon' or 'svg') |
| hasColumns | boolean | true | Whether to show columns |
| columnCount | integer | 4 | Number of columns (1-6) |

## Advanced Customization

Both components can be further customized through the `bcomponents.php` config file, where you can set default styles and behavior for each component. 