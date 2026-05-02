# bComponents Recipe Modularization Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix the current Button component fatal error and refactor long style recipes into small composable modules (better DX, easier maintenance).

**Architecture:** Keep recipe entrypoints pure and stable (`ButtonStyles::classes()`, `InputStyles::classes()`), but split internal responsibilities into modules (base/size/variant/tone/state). Components stay thin and call the entrypoint only.

**Tech Stack:** PHP 8.2+, Laravel Blade components, PHPUnit + Orchestra Testbench (CLI-only).

---

## File Map (Create/Modify)

**Modify**
- `src/Components/ButtonComponent.php`
- `src/Support/Styles/ButtonStyles.php`
- `src/Support/Styles/InputStyles.php`

**Create**
- `src/Support/Styles/Button/ButtonBase.php`
- `src/Support/Styles/Button/ButtonSizes.php`
- `src/Support/Styles/Button/ButtonVariants.php`
- `src/Support/Styles/Button/ButtonStates.php`
- `src/Support/Styles/Input/InputBase.php`
- `src/Support/Styles/Input/InputSizes.php`
- `src/Support/Styles/Input/InputStates.php`

---

### Task 1: Fix current test/runtime failure (ButtonComponent duplicate properties)

**Files:**
- Modify: `src/Components/ButtonComponent.php`

- [ ] **Step 1: Run the suite to confirm the failure**
Run:
```bash
vendor/bin/phpunit
```
Expected: FAIL with `Cannot redeclare ... ButtonComponent::$color`.

- [ ] **Step 2: Remove duplicated property declarations**
Keep only one block of legacy-compatibility properties (`color/isDisabled/isLoading/isBlock/isIconOnly`) and keep the v1 contract props intact.

- [ ] **Step 3: Re-run tests**
Run:
```bash
vendor/bin/phpunit
```
Expected: PASS (or proceed to Task 4 if new failures appear).

---

### Task 2: Modularize Button recipe

**Files:**
- Create: `src/Support/Styles/Button/*`
- Modify: `src/Support/Styles/ButtonStyles.php`

- [ ] **Step 1: Add module files**
Create:
- `ButtonBase::classes()` returns base layout/focus/radius/shadow classes.
- `ButtonSizes::classes($size)` returns padding/font sizing.
- `ButtonVariants::classes($variant, $tone)` returns solid/outline/ghost/link mappings (tone mapping can start with primary).
- `ButtonStates::classes($disabled, $loading, $fullWidth)` returns state classes.

- [ ] **Step 2: Compose in ButtonStyles**
Update `ButtonStyles::classes(array $opts)` to call modules and `trim()`/`implode()` to produce the final class string.

- [ ] **Step 3: Ensure output parity**
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

- [ ] **Step 1: Add module files**
Create:
- `InputBase::classes()` returns base layout/border/focus/shadow classes.
- `InputSizes::classes($size)` returns padding/font sizing.
- `InputStates::classes($invalid, $disabled)` returns invalid/disabled classes.

- [ ] **Step 2: Compose in InputStyles**
Update `InputStyles::classes(array $opts)` to call modules and return a final class string.

- [ ] **Step 3: Ensure output contains token surface**
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

- [ ] **Step 1: Run PHPUnit**
Run:
```bash
vendor/bin/phpunit
```
Expected: PASS.

- [ ] **Step 2: Git status sanity check**
Run:
```bash
git status --porcelain
```
Expected: only intended changes.

---

## Self-Review
- Button and Input recipes are split into modules without changing the public entrypoints.
- Components remain thin and do not embed large style logic.
- Tests pass without requiring a web URL/browser.

