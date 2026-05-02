# bComponents Recipe Modularization + Tier 1–3 Normalization Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Status:** Implemented in the current codebase. This document remains as a historical plan; prefer current docs and tests.

**Goal:** Fix style/initialization issues, modularize recipes, then normalize Tier 1–3 components (Alert/Card/Modal/Dropdown/Tabs) and add CLI-only render tests.

**Architecture:** Keep recipe entrypoints pure and stable (`ButtonStyles::classes()`, `InputStyles::classes()`), but split internal responsibilities into modules (base/size/variant/tone/state). Components stay thin and call the entrypoint only.

**Tech Stack:** PHP 8.2+, Laravel Blade components, PHPUnit + Orchestra Testbench (CLI-only).

---

## File Map (Create/Modify)

**Modify**
- `src/Components/ButtonComponent.php`
- `src/Components/BaseComponent.php`
- `src/Support/Styles/ButtonStyles.php`
- `src/Support/Styles/InputStyles.php`
 - `src/Support/ComponentRegistry.php`

**Create**
- `src/Support/Styles/Button/ButtonBase.php`
- `src/Support/Styles/Button/ButtonSizes.php`
- `src/Support/Styles/Button/ButtonVariants.php`
- `src/Support/Styles/Button/ButtonStates.php`
- `src/Support/Styles/Input/InputBase.php`
- `src/Support/Styles/Input/InputSizes.php`
- `src/Support/Styles/Input/InputStates.php`
 - `src/Components/DropdownComponent.php`
 - `src/Components/SelectDropdownComponent.php`
 - `src/Components/TabsComponent.php`
 - `src/Components/TabComponent.php`
 - `resources/views/components/dropdown.blade.php`
 - `resources/views/components/select-dropdown.blade.php`
 - `resources/views/components/tabs.blade.php`
 - `resources/views/components/tab.blade.php`
 - `tests/Feature/Components/AlertRenderTest.php`
 - `tests/Feature/Components/CardRenderTest.php`
 - `tests/Feature/Components/ModalRenderTest.php`
 - `tests/Feature/Components/DropdownRenderTest.php`
 - `tests/Feature/Components/SelectDropdownRenderTest.php`
 - `tests/Feature/Components/TabsRenderTest.php`

---

### Task 1: Fix current test/runtime failure (Button/Input duplicate properties)

**Files:**
- Modify: `src/Components/ButtonComponent.php`

- [x] **Step 1: Run the suite to confirm the failure**
Run:
```bash
vendor/bin/phpunit
```
Expected: FAIL with `Cannot redeclare ... ButtonComponent::$color`.

- [x] **Step 2: Remove duplicated property declarations**
Keep only one block of legacy-compatibility properties and keep the v1 contract props intact:
- `ButtonComponent`: remove duplicate `color/isDisabled/isLoading/isBlock/isIconOnly` block
- `InputComponent`: remove duplicate `invalid` declaration

- [x] **Step 3: Re-run tests**
Run:
```bash
vendor/bin/phpunit
```
Expected: PASS.

---

### Task 2: Modularize Button recipe

**Files:**
- Create: `src/Support/Styles/Button/*`
- Modify: `src/Support/Styles/ButtonStyles.php`

- [x] **Step 1: Add module files**
Create:
- `ButtonBase::classes()` returns base layout/focus/radius/shadow classes.
- `ButtonSizes::classes($size)` returns padding/font sizing.
- `ButtonVariants::classes($variant, $tone)` returns solid/outline/ghost/link mappings (tone mapping can start with primary).
- `ButtonStates::classes($disabled, $loading, $fullWidth)` returns state classes.

- [x] **Step 2: Compose in ButtonStyles**
Update `ButtonStyles::classes(array $opts)` to call modules and `trim()`/`implode()` to produce the final class string.

- [x] **Step 3: Ensure output parity**
Sanity-check by comparing output for default options:
```bash
php -r 'require "vendor/autoload.php"; echo \Zakarialabib\BComponents\Support\Styles\ButtonStyles::classes([]);'
```
Expected: includes token-based `bg-[color:var(--b-color-primary)]`.

---

### Task 3: Modularize Input recipe

**Files:**
- Create: `src/Support/Styles/Input/*`
- Modify: `src/Support/Styles/InputStyles.php`

- [x] **Step 1: Add module files**
Create:
- `InputBase::classes()` returns base layout/border/focus/shadow classes.
- `InputSizes::classes($size)` returns padding/font sizing.
- `InputStates::classes($invalid, $disabled)` returns invalid/disabled classes.

- [x] **Step 2: Compose in InputStyles**
Update `InputStyles::classes(array $opts)` to call modules and return a final class string.

- [x] **Step 3: Ensure output contains token surface**
Run:
```bash
php -r 'require "vendor/autoload.php"; echo \Zakarialabib\BComponents\Support\Styles\InputStyles::classes([]);'
```
Expected: includes `bg-[color:var(--b-color-surface)]`.

---

### Task 4: Verify (CLI-only)

**Files:**
- Test: `tests/Feature/Components/ButtonRenderTest.php`
- Test: `tests/Feature/Components/InputRenderTest.php`

- [x] **Step 1: Run PHPUnit**
Run:
```bash
vendor/bin/phpunit
```
Expected: PASS.

- [x] **Step 2: Git status sanity check**
Run:
```bash
git status --porcelain
```
Expected: only intended changes.

---

---

### Task 5: Normalize Alert/Card/Modal to v1 conventions

**Files:**
- Modify: `src/Components/AlertComponent.php`
- Modify: `resources/views/components/alert.blade.php`
- Modify: `src/Components/CardComponent.php`
- Modify: `resources/views/components/card.blade.php`
- Modify: `src/Components/ModalComponent.php`
- Modify: `resources/views/components/modal.blade.php`

- [ ] **Step 1: Normalize class → view contract**
For each component:
- ensure the Blade view props match the class public props (no unused public knobs)
- ensure the class passes a `classes` string (recipe-driven where applicable) and the view uses `$attributes->merge(['class' => $classes])`
- keep Alpine behavior rerender-safe (no browser tests required)

- [ ] **Step 2: Token alignment**
Replace hardcoded palette classes where practical with token classes:
- surfaces should use `bg-[color:var(--b-color-surface)]` and `text-[color:var(--b-color-text)]`
- borders should use `border-[color:var(--b-color-border)]`

- [ ] **Step 3: Render tests**
Implement/extend tests to validate:
- Alert renders with `role="alert"` and includes `x-data` hooks
- Card renders header only when title/subtitle exists
- Modal renders open/close window event hooks and respects `static` mode

---

### Task 6: Add class-based Dropdown + SelectDropdown

**Files:**
- Create: `src/Components/DropdownComponent.php`
- Create: `src/Components/SelectDropdownComponent.php`
- Modify: `src/Support/ComponentRegistry.php`
- Create: `resources/views/components/dropdown.blade.php`
- Create: `resources/views/components/select-dropdown.blade.php`

- [ ] **Step 1: Dropdown (menu-style) contract**
Implement `<x-b-dropdown>` as a menu dropdown using slots:
- `trigger` slot (required)
- `content` slot (required)
- props: `align` (`left|right`), `width` (`sm|md|lg`), `open` (default false)
Use Alpine `x-data="{ open: false }"`, close on click-away + escape.

- [ ] **Step 2: SelectDropdown contract**
Implement `<x-b-select-dropdown>` for the input/select-style dropdown:
- props: `name`, `placeholder`, `options` (array of `['value'=>..., 'label'=>...]`), `value` (selected), `required`, `disabled`
Keep behavior purely client-side (Alpine) and do not require Livewire.

- [ ] **Step 3: Registry**
Register:
- `dropdown` → `DropdownComponent`
- `select-dropdown` → `SelectDropdownComponent`

---

### Task 7: Add class-based Tabs + Tab (slot-based)

**Files:**
- Create: `src/Components/TabsComponent.php`
- Create: `src/Components/TabComponent.php`
- Modify: `src/Support/ComponentRegistry.php`
- Create: `resources/views/components/tabs.blade.php`
- Create: `resources/views/components/tab.blade.php`

- [ ] **Step 1: Tabs contract**
Implement:
```blade
<x-b-tabs default="general">
  <x-b-tab name="general" title="General">...</x-b-tab>
  <x-b-tab name="security" title="Security">...</x-b-tab>
</x-b-tabs>
```
Rules:
- no global `<script>` tags
- Alpine state lives on the root tabs: `x-data="{ active: 'general' }"`
- each tab renders its panel and header integrates via attributes/ids

- [ ] **Step 2: Registry**
Register:
- `tabs` → `TabsComponent`
- `tab` → `TabComponent`

---

### Task 8: Add tests for Alert/Card/Modal/Dropdown/SelectDropdown/Tabs

**Files:**
- Create: `tests/Feature/Components/AlertRenderTest.php`
- Create: `tests/Feature/Components/CardRenderTest.php`
- Create: `tests/Feature/Components/ModalRenderTest.php`
- Create: `tests/Feature/Components/DropdownRenderTest.php`
- Create: `tests/Feature/Components/SelectDropdownRenderTest.php`
- Create: `tests/Feature/Components/TabsRenderTest.php`

- [ ] **Step 1: Add tests using Blade::render()**
Each test should:
- render the component with minimal props
- assert core markup, attribute merging, and key Alpine hooks exist

- [ ] **Step 2: Run PHPUnit**
Run:
```bash
vendor/bin/phpunit
```
Expected: PASS.

---

## Self-Review
- Button and Input recipes are split into modules without changing the public entrypoints.
- Components remain thin and do not embed large style logic.
- Tests pass without requiring a web URL/browser.
- Dropdown and Tabs APIs are unambiguous (split dropdown types, one tabs API).
