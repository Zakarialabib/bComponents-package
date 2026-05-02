# Full Component Coverage v1 Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Make every registered Blade component and shipped Livewire component adoption-ready by enforcing a single v1 contract (props/slots/a11y/theming/tests/docs) even if it requires breaking changes.

**Architecture:** Treat `ComponentRegistry` and Livewire registration as the only “public surface” sources of truth. Normalize each component family to consistent prop naming + token-first styling. Enforce invariants via tests (no missing views, docs pages, metadata coverage, and render smoke tests).

**Tech Stack:** PHP (Laravel 11+ package), Blade components, Livewire 3/4, Alpine.js, Tailwind v4, PHPUnit (Orchestra Testbench), PHPStan.

---

## File Structure / Boundaries

**Public Surface (source of truth)**
- Modify: [ComponentRegistry.php](file:///workspace/src/Support/ComponentRegistry.php)
- Modify: [BComponentsServiceProvider.php](file:///workspace/src/BComponentsServiceProvider.php) (Livewire registration + gating)

**Component Implementations**
- Modify: `src/Components/*.php`
- Modify: `resources/views/components/**/*.blade.php`
- Modify: `src/Livewire/*.php`
- Modify: `resources/views/livewire/*.blade.php`

**Docs + Metadata**
- Modify: [readme.md](file:///workspace/readme.md)
- Modify/Create: `docs/components/**` (manual “real” docs, not auto-baseline)
- Modify: [ComponentMetadataRepository.php](file:///workspace/src/Support/Metadata/ComponentMetadataRepository.php)

**Tests (invariants + behavior)**
- Modify/Create: `tests/Feature/Components/*`
- Modify/Create: `tests/Feature/Livewire/*`
- Modify/Create: `tests/Feature/*Integrity*.php`

---

## Definition of Done (per component)

- **Contract:** Constructor props define the public API; legacy aliases only when explicitly justified.
- **Styling:** Token-first (CSS variables) and recipe-first; hard-coded Tailwind palette only for explicitly “legacy” components.
- **A11y:** Has the required roles/aria/keyboard behavior for its family.
- **Docs:** Has a complete page under `docs/components/...` with copy/paste examples that match code truth.
- **Tests:** Has at least one render smoke test; interactive components have minimal behavior/a11y tests.

---

### Task 1: Create a dedicated work branch and capture current baseline

**Files:** none

- [ ] **Step 1: Create branch**
Run:
```bash
git checkout main
git pull --ff-only
git checkout -b feature/full-component-coverage-v1
```

- [ ] **Step 2: Install + baseline verification**
Run:
```bash
composer install --no-interaction --no-progress --prefer-dist
vendor/bin/phpunit
vendor/bin/phpstan analyse --no-progress --memory-limit=1G
```
Expected: PASS.

- [ ] **Step 3: Snapshot the public surface**
Confirm:
- Blade aliases: [ComponentRegistry.php](file:///workspace/src/Support/ComponentRegistry.php)
- Livewire aliases: `registerLivewireComponents()` in provider

---

### Task 2: Normalize API contracts by family (breaking changes allowed)

**Files:**
- Modify: `src/Components/*Component.php`
- Modify: `resources/views/components/**/*.blade.php`

#### Family A — Primitives (forms + small UI)
- [ ] **Step 1: Make prop naming consistent**
Target canonical props:
- `tone`, `variant`, `size`
- `disabled`, `required`, `invalid`
- `icon`, `iconPosition`, `iconOnly`

Rules:
- Remove “shadow” legacy variants unless kept as aliases.
- Ensure every view uses `$attributes->merge(['class' => $classes])`.

- [ ] **Step 2: Add/expand render tests per primitive**
Add tests under `tests/Feature/Components/`:
- `ButtonRenderTest`
- `InputRenderTest`
- `TextareaRenderTest`
- `SelectRenderTest`
- `CheckboxRenderTest`
- `RadioRenderTest`
- `ToggleRenderTest`
- `BadgeRenderTest`
- `LoadingRenderTest`

Each test should:
```php
$this->blade('<x-b-xyz ... />')->assertSee(...);
```
and cover:
- default render does not throw
- class merge includes custom classes

#### Family B — Layout / Composition
- [ ] **Step 3: Normalize layout components to be “dumb wrappers”**
Components: `container`, `grid`, `flex`, `spacer`, `divider`, `card`

Rules:
- Prefer minimal props.
- Ensure responsive arrays are documented and deterministic.

- [ ] **Step 4: Add render tests**
One render test per component verifying:
- wrapper element exists
- critical class names appear

#### Family C — Overlays / Interactive (Alpine)
- [ ] **Step 5: Standardize event names + keyboard behaviors**
Components: `modal`, `drawer`, `dropdown`, `toast`, `accordion`, `tabs/tab`, `select-dropdown`

Rules:
- Global open/close events should follow consistent naming:
  - modal: `open-modal`, `close-modal` (already)
  - drawer: `open-drawer`, `close-drawer`
- Must support `Escape` close for dismissible overlays.
- Must have click-away close when not `static`.
- Must emit/contain minimum aria markers (role + aria-expanded where applicable).

- [ ] **Step 6: Add behavior-focused tests**
Use Blade render assertions to validate:
- presence of role / aria attributes in HTML output
- presence of expected Alpine directives (`x-data`, `@keydown.escape`, etc.)

---

### Task 3: Livewire suite hardening (keep “experimental” label until dependencies are bundled)

**Files:**
- Modify: `src/Livewire/*.php`
- Modify: `resources/views/livewire/*.blade.php`
- Modify/Create: `tests/Feature/Livewire/*`

- [ ] **Step 1: Ensure every Livewire component has a canonical view and renders**
Add/extend smoke tests:
- `LivewireSmokeTest` should cover every component class.

- [ ] **Step 2: Make external dependencies explicit**
For each requiring external JS:
- Date picker → Flatpickr
- Rich text editor → CKEditor

Document required integration in the component’s catalog page and in README.

- [ ] **Step 3: Add minimal behavior tests where feasible**
Examples:
- `MultiSelectComponent`: selecting/removing updates state
- `FileUploadComponent`: rules exist and render does not crash without files

---

### Task 4: Turn docs/components from baseline into “real docs”

**Files:**
- Modify/Create: `docs/components/index.md`
- Modify: `docs/components/blade/*.md`
- Modify: `docs/components/livewire/*.md`

- [ ] **Step 1: Index taxonomy**
Group by:
- Foundation / Primitives / Forms / Layout / Feedback / Navigation / Overlays / Data Display / Livewire / Legacy

- [ ] **Step 2: Per-component page template**
Every page must include:
- Tag
- Status (stable/legacy/experimental)
- Props table (name/type/default/notes)
- Slots section
- A11y section
- Dependencies section
- Copy/paste examples (basic + advanced)
- Code references

---

### Task 5: Align metadata to the same public surface

**Files:**
- Modify: [ComponentMetadataRepository.php](file:///workspace/src/Support/Metadata/ComponentMetadataRepository.php)
- Modify/Create: `tests/Feature/MetadataRepositoryTest.php`

- [ ] **Step 1: Ensure every registry alias has metadata**
- [ ] **Step 2: Ensure every Livewire alias has metadata under `livewire.*`**

---

### Task 6: Enforce “no drift” via tests

**Files:**
- Modify/Create: `tests/Feature/*Integrity*.php`

- [ ] **Step 1: Fail if any registry alias lacks a view**
- [ ] **Step 2: Fail if any public component lacks a docs page**
- [ ] **Step 3: Fail if metadata coverage is missing**

---

### Task 7: Final verification + release hygiene

**Files:** varies

- [ ] **Step 1: Full verification**
Run:
```bash
vendor/bin/phpunit
vendor/bin/phpstan analyse --no-progress --memory-limit=1G
```

- [ ] **Step 2: Grep for forbidden drift**
Run:
```bash
rg \"livewire:livewire-|data-toggle=\\\"modal\\\"|default_classes|css_framework\" -n . -S
```
Expected: no matches in user-facing docs; internal historical plans may mention removed keys as historical notes.

- [ ] **Step 3: Commit + push**
Run:
```bash
git add .
git commit -m \"feat: full component coverage v1\"\n+git push -u origin feature/full-component-coverage-v1
```

