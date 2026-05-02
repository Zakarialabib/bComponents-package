# bComponents v1 Contract Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Refactor the package into a stable, Blade-first `<x-b-*>` component library with a minimal config, centralized registration, token-based theming, recipe-driven classes, metadata scaffolding, and a test baseline.

**Architecture:** Keep existing class-based Blade components, but route registration through a single registry and compute classes through centralized recipe builders. Ship theme tokens as plain CSS variables and reference them via Tailwind v4 arbitrary values in Blade class strings.

**Tech Stack:** PHP 8.1–8.3, Laravel 11/12/13 (Illuminate 11/12/13), Livewire 3/4, Alpine.js, Tailwind CSS v4, Orchestra Testbench, PHPUnit.

---

## File Map (Create/Modify)

**Modify**
- [composer.json](file:///workspace/composer.json)
- [src/BComponentsServiceProvider.php](file:///workspace/src/BComponentsServiceProvider.php)
- [config/bcomponents.php](file:///workspace/config/bcomponents.php)
- Selected component PHP classes under [src/Components](file:///workspace/src/Components)
- Selected Blade templates under [resources/views/components](file:///workspace/resources/views/components)
- [readme.md](file:///workspace/readme.md)

**Create**
- `src/Support/ComponentRegistry.php`
- `src/Support/Styles/ButtonStyles.php`
- `src/Support/Styles/InputStyles.php`
- `src/Support/Styles/SurfaceStyles.php`
- `src/Support/Metadata/ComponentMetadataRepository.php`
- `resources/css/bcomponents.css`
- `resources/css/themes/default.css`
- `tests/TestCase.php`
- `tests/Feature/Components/ButtonRenderTest.php`
- `tests/Feature/Components/InputRenderTest.php`
- `phpunit.xml` (if missing)

---

### Task 1: Align package support matrix (Laravel 11/12/13, Livewire 3/4)

**Files:**
- Modify: [composer.json](file:///workspace/composer.json)

- [ ] **Step 1: Update composer constraints**
  - Set:
    - `illuminate/*` to `^11.0|^12.0|^13.0`
    - `livewire/livewire` to `^3.0|^4.0`
    - `php` to `^8.2|^8.3` (match README) OR update README to reflect PHP 8.1 support; pick one and keep consistent.

- [ ] **Step 2: Validate composer resolves**

Run:
```bash
composer update --no-interaction
```
Expected: completes without dependency conflicts.

---

### Task 2: Replace config with the minimal v1 schema (keep `<x-b-*>`)

**Files:**
- Modify: [config/bcomponents.php](file:///workspace/config/bcomponents.php)
- Modify: [readme.md](file:///workspace/readme.md)

- [ ] **Step 1: Replace config contents**
  - Replace the file with:
    - `prefix` default `'b'`
    - `theme`: `preset` (`default`), `dark_mode` (true), `tokens_path` (null)
    - `components`: `enabled` (array; empty array means “all enabled”)
    - `assets`: `include_css`/`include_js` (true)
    - `livewire`: `enabled` (true), `compatibility_mode` (`auto`)
    - `docs`: `metadata` (true)

- [ ] **Step 2: Update README config section (BREAKING)**
  - Add a “Breaking config changes” note:
    - `default_classes` removed
    - `css_framework` removed (Tailwind only)

---

### Task 3: Centralize Blade component registration via a registry (prefix remains `b`)

**Files:**
- Create: `src/Support/ComponentRegistry.php`
- Modify: [src/BComponentsServiceProvider.php](file:///workspace/src/BComponentsServiceProvider.php)

- [ ] **Step 1: Create `ComponentRegistry`**
Implement:
```php
<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support;

final class ComponentRegistry
{
    public function aliases(): array
    {
        return [
            'accordion' => \Zakarialabib\BComponents\Components\AccordionComponent::class,
            'alert' => \Zakarialabib\BComponents\Components\AlertComponent::class,
            'badge' => \Zakarialabib\BComponents\Components\BadgeComponent::class,
            'breadcrumb' => \Zakarialabib\BComponents\Components\BreadcrumbComponent::class,
            'button' => \Zakarialabib\BComponents\Components\ButtonComponent::class,
            'card' => \Zakarialabib\BComponents\Components\CardComponent::class,
            'checkbox' => \Zakarialabib\BComponents\Components\CheckboxComponent::class,
            'container' => \Zakarialabib\BComponents\Components\ContainerComponent::class,
            'divider' => \Zakarialabib\BComponents\Components\DividerComponent::class,
            'drawer' => \Zakarialabib\BComponents\Components\DrawerComponent::class,
            'flex' => \Zakarialabib\BComponents\Components\FlexComponent::class,
            'footer' => \Zakarialabib\BComponents\Components\FooterComponent::class,
            'form-group' => \Zakarialabib\BComponents\Components\FormGroupComponent::class,
            'grid' => \Zakarialabib\BComponents\Components\GridComponent::class,
            'header' => \Zakarialabib\BComponents\Components\HeaderComponent::class,
            'input' => \Zakarialabib\BComponents\Components\InputComponent::class,
            'loading' => \Zakarialabib\BComponents\Components\LoadingComponent::class,
            'modal' => \Zakarialabib\BComponents\Components\ModalComponent::class,
            'radio' => \Zakarialabib\BComponents\Components\RadioComponent::class,
            'select' => \Zakarialabib\BComponents\Components\SelectComponent::class,
            'spacer' => \Zakarialabib\BComponents\Components\SpacerComponent::class,
            'table' => \Zakarialabib\BComponents\Components\TableComponent::class,
            'table.header' => \Zakarialabib\BComponents\Components\Table\TableHeaderComponent::class,
            'table.body' => \Zakarialabib\BComponents\Components\Table\TableBodyComponent::class,
            'table.row' => \Zakarialabib\BComponents\Components\Table\TableRowComponent::class,
            'table.cell' => \Zakarialabib\BComponents\Components\Table\TableCellComponent::class,
            'textarea' => \Zakarialabib\BComponents\Components\TextareaComponent::class,
            'toast' => \Zakarialabib\BComponents\Components\ToastComponent::class,
            'toggle' => \Zakarialabib\BComponents\Components\ToggleComponent::class,
        ];
    }

    public function enabled(string $alias): bool
    {
        $enabled = config('bcomponents.components.enabled', []);
        if (!is_array($enabled) || $enabled === []) {
            return true;
        }

        return (bool) ($enabled[$alias] ?? true);
    }
}
```

- [ ] **Step 2: Refactor service provider to use registry**
  - Instantiate `ComponentRegistry`
  - Read `$prefix = config('bcomponents.prefix', 'b')` (keep `<x-b-*>`)
  - Loop aliases and register only if enabled.

- [ ] **Step 3: Run a quick smoke render**
Run:
```bash
php -r "require 'vendor/autoload.php'; echo 'ok';"
```
Expected: `ok`

---

### Task 4: Add Tailwind v4 token CSS (variables) with default preset + dark mode

**Files:**
- Create: `resources/css/bcomponents.css`
- Create: `resources/css/themes/default.css`
- Modify: [src/BComponentsServiceProvider.php](file:///workspace/src/BComponentsServiceProvider.php) (publishable assets)
- Modify: [readme.md](file:///workspace/readme.md)

- [ ] **Step 1: Create token files**
`resources/css/bcomponents.css` should define the base token surface:
```css
:root {
  --b-color-primary: #2563eb;
  --b-color-surface: #ffffff;
  --b-color-border: #e5e7eb;
  --b-color-text: #111827;
  --b-radius-md: 0.5rem;
  --b-shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  --b-spacing-control-x: 1rem;
  --b-font-size-sm: 0.875rem;
}

.dark {
  --b-color-surface: #0b1220;
  --b-color-border: #1f2937;
  --b-color-text: #f9fafb;
}
```

`resources/css/themes/default.css` can extend/override defaults:
```css
:root {
  --b-color-primary: #2563eb;
}
```

- [ ] **Step 2: Publish CSS assets**
  - Ensure provider publishes `resources/css` into `public/vendor/bcomponents` (or keep existing `public` publish strategy and add these files there during build, depending on current package conventions).

- [ ] **Step 3: Update README on Tailwind v4 usage**
  - Document `content` paths (package Blade templates).
  - Document how to include token CSS and override tokens via `tokens_path`.

---

### Task 5: Implement recipe builders (Button/Input/Surface)

**Files:**
- Create: `src/Support/Styles/ButtonStyles.php`
- Create: `src/Support/Styles/InputStyles.php`
- Create: `src/Support/Styles/SurfaceStyles.php`
- Modify: selected component classes to use recipes (start with Button + Input)

- [ ] **Step 1: Create `ButtonStyles`**
```php
<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles;

final class ButtonStyles
{
    public static function classes(array $opts): string
    {
        $variant = (string) ($opts['variant'] ?? 'solid');
        $size = (string) ($opts['size'] ?? 'md');
        $tone = (string) ($opts['tone'] ?? 'primary');
        $disabled = (bool) ($opts['disabled'] ?? false);
        $loading = (bool) ($opts['loading'] ?? false);
        $fullWidth = (bool) ($opts['full_width'] ?? false);

        $base = 'inline-flex items-center justify-center font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-150 select-none';
        $radius = 'rounded-[var(--b-radius-md)]';
        $sizes = [
            'sm' => 'px-3 py-2 text-sm',
            'md' => 'px-4 py-2 text-sm',
            'lg' => 'px-5 py-2.5 text-base',
        ];
        $toneBg = match ($tone) {
            default => 'bg-[color:var(--b-color-primary)] text-white',
        };

        $variantClasses = match ($variant) {
            'outline' => 'border border-[color:var(--b-color-border)] bg-transparent text-[color:var(--b-color-text)]',
            'ghost' => 'bg-transparent text-[color:var(--b-color-text)]',
            'link' => 'bg-transparent text-[color:var(--b-color-primary)] underline-offset-4 hover:underline',
            default => $toneBg,
        };

        $state = trim(implode(' ', array_filter([
            $disabled ? 'opacity-50 cursor-not-allowed' : '',
            $loading ? 'opacity-75 cursor-wait' : '',
            $fullWidth ? 'w-full' : '',
        ])));

        return trim($base.' '.$radius.' '.($sizes[$size] ?? $sizes['md']).' '.$variantClasses.' '.$state);
    }
}
```

- [ ] **Step 2: Create `InputStyles` and `SurfaceStyles`**
  - Use the same pattern: `public static function classes(array $opts): string`
  - Reference tokens using Tailwind v4 arbitrary values (e.g. `border-[color:var(--b-color-border)]`, `bg-[color:var(--b-color-surface)]`, `text-[color:var(--b-color-text)]`).

---

### Task 6: Normalize v1 core components to the contract (start with Button + Input)

**Files:**
- Modify: [src/Components/ButtonComponent.php](file:///workspace/src/Components/ButtonComponent.php)
- Modify: [resources/views/components/button.blade.php](file:///workspace/resources/views/components/button.blade.php)
- Modify: `src/Components/InputComponent.php` and [resources/views/components/input.blade.php](file:///workspace/resources/views/components/input.blade.php)

- [ ] **Step 1: Button props normalization**
  - Public props:
    - `variant`, `size`, `tone`, `disabled`, `loading`, `icon`, `class`
    - Keep `href` support (renders `<a>` vs `<button>`)
  - Back-compat mapping (optional but recommended):
    - Map existing `color` → `tone`
    - Map `isDisabled` → `disabled`
    - Map `isLoading` → `loading`

- [ ] **Step 2: Button view standard attribute merge**
  - Use `$attributes->merge(['class' => $classes])` where `$classes` already includes computed recipe classes + user classes merged in PHP (or do merge in Blade).

- [ ] **Step 3: Input props normalization**
  - Standardize: `disabled`, `invalid`, `help`, `label`, `class`
  - Ensure `wire:model` passes through without special casing.

- [ ] **Step 4: Expand normalization to remaining Tier 1–3 components**
  - Alert/Card/Modal/Dropdown/Tabs: align prop names to `variant/size/tone` where applicable, and define stable slots.

---

### Task 7: Metadata scaffolding (docs/portal ready)

**Files:**
- Create: `src/Support/Metadata/ComponentMetadataRepository.php`

- [ ] **Step 1: Define repository API**
Implement:
```php
<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Metadata;

final class ComponentMetadataRepository
{
    public function all(): array
    {
        return [
            'button' => [
                'name' => 'Button',
                'category' => 'primitives',
                'props' => [
                    'variant' => ['type' => 'string', 'default' => 'solid'],
                    'size' => ['type' => 'string', 'default' => 'md'],
                    'tone' => ['type' => 'string', 'default' => 'primary'],
                    'disabled' => ['type' => 'bool', 'default' => false],
                    'loading' => ['type' => 'bool', 'default' => false],
                    'icon' => ['type' => 'string|null', 'default' => null],
                ],
                'slots' => ['default'],
                'a11y' => ['Use <button> semantics; add aria-disabled when disabled on <a>.'],
                'compat' => ['Blade', 'Livewire 3/4', 'Alpine optional'],
            ],
        ];
    }
}
```

- [ ] **Step 2: Wire repository into container (optional)**
  - Bind it as a singleton in the service provider for easy consumption.

---

### Task 8: Test baseline (Blade render + selected Livewire)

**Files:**
- Create: `tests/TestCase.php`
- Create: `tests/Feature/Components/ButtonRenderTest.php`
- Create: `tests/Feature/Components/InputRenderTest.php`
- Create/Modify: `phpunit.xml`

- [ ] **Step 1: Add Testbench TestCase**
`tests/TestCase.php`:
```php
<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

final class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [\Zakarialabib\BComponents\BComponentsServiceProvider::class];
    }
}
```

- [ ] **Step 2: Add a Blade render smoke test**
`tests/Feature/Components/ButtonRenderTest.php`:
```php
<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Zakarialabib\BComponents\Tests\TestCase;

final class ButtonRenderTest extends TestCase
{
    public function test_renders_button(): void
    {
        $view = $this->blade('<x-b-button>Save</x-b-button>');
        $view->assertSee('Save');
        $view->assertSee('class="', false);
    }
}
```

- [ ] **Step 3: Run test suite**
Run:
```bash
vendor/bin/phpunit
```
Expected: PASS

---

## Plan Self-Review (against spec)
- Covers config contract replacement (Task 2)
- Covers centralized registration + prefix `<x-b-*>` (Task 3)
- Covers theme tokens + dark mode (Task 4)
- Covers style recipes (Task 5)
- Covers component normalization (Task 6)
- Covers metadata scaffolding (Task 7)
- Covers automated tests (Task 8)

