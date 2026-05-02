# bComponents v1 Tier 1–3 Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Status:** Implemented in the current codebase. This document remains as a historical execution plan; prefer current docs (`readme.md`, `instructions.md`) and tests as the truth.

**Goal:** Ship a stable, Blade-first `<x-b-*>` component package with a minimal config contract, centralized registration, token-based theming, recipe-based styling, Livewire-safe behavior, and CLI-only tests for Tier 1–3 components.

**Architecture:** Keep class-based Blade components but normalize a v1 prop contract (`variant/size/tone/disabled/loading`) and compute classes via recipe builders referencing semantic CSS-variable tokens (Tailwind v4 direction). Load views with override-first semantics and support both current view trees until consolidated.

**Tech Stack:** PHP 8.2+, Laravel 11/12/13, Livewire 3/4, Alpine (optional), Tailwind v4 (token-first), PHPUnit + Orchestra Testbench, PHPStan.

---

## File Map (Create/Modify)

**Modify**
- `composer.json`
- `src/BComponentsServiceProvider.php`
- `config/bcomponents.php`
- `readme.md`
- Component classes under `src/Components/*Component.php`
- Blade views under `resources/views` (canonical). `src/resources/views` is legacy and not loaded by the package provider.

**Create**
- `src/Support/ComponentRegistry.php`
- `src/Support/Styles/ButtonStyles.php`
- `src/Support/Styles/InputStyles.php`
- `src/Support/Styles/SurfaceStyles.php`
- `resources/css/bcomponents.css`
- `resources/css/themes/default.css`
- `phpunit.xml`
- `tests/TestCase.php`
- `tests/Feature/Components/*RenderTest.php` (one per core component)

---

### Task 1: Update package support matrix (Laravel 11/12/13, Livewire 3/4, PHP 8.2+)

**Files:**
- Modify: `composer.json`

- [ ] **Step 1: Update constraints**
  - Set:
    - `php` to `^8.2|^8.3`
    - `illuminate/*` to `^11.0|^12.0|^13.0`
    - `livewire/livewire` to `^3.0|^4.0`
    - `orchestra/testbench` to `^9.0|^10.0|^11.0`

- [ ] **Step 2: Resolve dependencies**
Run:
```bash
composer update --no-interaction
```
Expected: exit code 0.

---

### Task 2: Replace config with minimal v1 schema (keep prefix `b`)

**Files:**
- Modify: `config/bcomponents.php`
- Modify: `readme.md`

- [ ] **Step 1: Replace config file**
Replace with:
```php
<?php

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

- [ ] **Step 2: Update README**
  - Requirements: Tailwind 4, Livewire 3/4
  - Tailwind content path(s): include whichever view tree(s) are actually shipped (prefer root `resources/views` once consolidated)
  - Add BREAKING note: `default_classes` removed, `css_framework` removed

---

### Task 3: Fix service provider view loading + add registry-driven registration

**Files:**
- Modify: `src/BComponentsServiceProvider.php`
- Create: `src/Support/ComponentRegistry.php`

- [ ] **Step 1: Create `ComponentRegistry`**
Create `src/Support/ComponentRegistry.php`:
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

- [ ] **Step 2: Load views using standard Laravel package conventions**
Update `boot()` to load one canonical package view root:
- package root: `__DIR__ . '/../resources/views'`

Expected: `bcomponents::components.*` and `bcomponents::livewire.*` resolve, and consumers override views via `resources/views/vendor/bcomponents` after publishing.

- [ ] **Step 3: Register Blade components from registry**
Update registration to:
```php
$prefix = (string) config('bcomponents.prefix', 'b');
$registry = $this->app->make(\Zakarialabib\BComponents\Support\ComponentRegistry::class);
foreach ($registry->aliases() as $alias => $class) {
    if ($registry->enabled($alias)) {
        \Illuminate\Support\Facades\Blade::component($class, "{$prefix}-{$alias}");
    }
}
```

- [ ] **Step 4: Smoke check**
Run:
```bash
php -r "require 'vendor/autoload.php'; echo 'ok';"
```
Expected: `ok`

---

### Task 4: Add token CSS + default preset (Tailwind v4 direction)

**Files:**
- Create: `resources/css/bcomponents.css`
- Create: `resources/css/themes/default.css`
- Modify: `src/BComponentsServiceProvider.php` (publishing paths)

- [ ] **Step 1: Create base token CSS**
`resources/css/bcomponents.css`:
```css
:root {
  --b-color-primary: #2563eb;
  --b-color-surface: #ffffff;
  --b-color-border: #e5e7eb;
  --b-color-text: #111827;
  --b-radius-md: 0.5rem;
  --b-shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
}

.dark {
  --b-color-surface: #0b1220;
  --b-color-border: #1f2937;
  --b-color-text: #f9fafb;
}
```

- [ ] **Step 2: Create default theme preset**
`resources/css/themes/default.css`:
```css
:root {
  --b-color-primary: #2563eb;
}
```

- [ ] **Step 3: Publish assets**
Publish `resources/css` and `resources/js` to `public/vendor/bcomponents/{css,js}` under `bcomponents-assets`.

---

### Task 5: Add recipe style builders (Button/Input/Surface)

**Files:**
- Create: `src/Support/Styles/ButtonStyles.php`
- Create: `src/Support/Styles/InputStyles.php`
- Create: `src/Support/Styles/SurfaceStyles.php`

- [ ] **Step 1: Implement ButtonStyles**
Implement token-based Tailwind v4 classes using arbitrary values (e.g. `bg-[color:var(--b-color-primary)]`).

- [ ] **Step 2: Implement InputStyles**
Support `size`, `invalid`, `disabled`.

- [ ] **Step 3: Implement SurfaceStyles**
Support variants like `default`, `bordered`, `elevated`.

---

### Task 6: Normalize Tier 1–3 components to v1 contract (with compatibility mapping)

**Files:**
- Modify: `src/Components/*Component.php` for Tier 1–3 components
- Modify: Blade views for those components (canonical view tree(s) used by provider)

- [ ] **Step 1: Normalize Button + Input first**
  - Button: support `tone/variant/size/disabled/loading/fullWidth` and map legacy props (`color`, `isDisabled`, `isLoading`, `isBlock`) internally
  - Input: support `invalid` and use InputStyles; preserve existing addon UI

- [ ] **Step 2: Normalize the rest of Tier 1 (forms + primitives)**
Targets:
  - Badge, Checkbox, Radio, Select, Textarea, Toggle, Divider, Loading/Spinner

- [ ] **Step 3: Normalize Tier 2–3 shells**
Targets:
  - Alert, Card, Modal, Drawer, Dropdown, Tabs

Contract expectations:
  - consistent attribute merging (`$attributes->merge(['class' => $classes])`)
  - default styles come from recipes (or SurfaceStyles)
  - Livewire-safe and Alpine minimal for interactive shells

---

### Task 7: Add CLI-only tests (Testbench + PHPUnit)

**Files:**
- Create: `phpunit.xml`
- Create: `tests/TestCase.php`
- Create: `tests/Feature/Components/*RenderTest.php`

- [ ] **Step 1: Testbench harness**
Add `tests/TestCase.php` extending `Orchestra\Testbench\TestCase` and registering `BComponentsServiceProvider`.

- [ ] **Step 2: Add render tests**
Create smoke tests asserting:
  - each component renders without exception
  - `class` merging preserves user classes
  - key token classes appear for button/input (ensures recipe path is used)

- [ ] **Step 3: Run tests**
Run:
```bash
vendor/bin/phpunit
```
Expected: PASS.

---

### Task 8: Self-review and alignment cleanup

- [ ] **Step 1: Verify view paths**
Confirm `bcomponents::components.*` and `bcomponents::livewire.*` do not depend on `src/resources/views` (legacy) and that any remaining legacy templates are migrated or clearly marked as legacy.

- [ ] **Step 2: Verify docs**
Update README Tailwind content paths to match actual shipped view tree(s).
