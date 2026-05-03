# Overlay Contract + Supported Livewire Assets Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Standardize overlay components (modal/drawer/dropdown/tabs/toast) to a single Alpine/a11y contract, and ship a published, bundled JS file (`vendor/bcomponents/js/bcomponents.js`) that includes Flatpickr + CKEditor so Livewire components can be treated as “supported”.

**Architecture:** Add a single compiled JS entry (`resources/js/bcomponents.js`) that registers Alpine behavior modules (overlay/tabs/dropdown/toast) and bundles Livewire deps (Flatpickr + CKEditor). Compile to `dist/js/bcomponents.js` (non-hashed) and publish `dist/js` to `public/vendor/bcomponents/js`. Update `<x-b-assets />` to load the new bundle and adjust Livewire views to rely on bundled globals.

**Tech Stack:** Vite 5, laravel-vite-plugin, Alpine.js, Flatpickr, CKEditor 5 Classic build, Blade, Livewire 3/4, PHPUnit.

---

## File Structure / Boundaries

**Bundled JS (source + dist)**
- Create: [resources/js/bcomponents.js](file:///workspace/resources/js/bcomponents.js)
- Modify: [vite.config.js](file:///workspace/vite.config.js)
- Modify: [package.json](file:///workspace/package.json)
- Generate/Commit: `dist/js/bcomponents.js` (and optional map)

**Assets publishing and loading**
- Modify: [BComponentsServiceProvider.php](file:///workspace/src/BComponentsServiceProvider.php)
- Modify: [assets.blade.php](file:///workspace/resources/views/components/assets.blade.php)

**Overlay views (Alpine + a11y contract)**
- Modify: [modal.blade.php](file:///workspace/resources/views/components/modal.blade.php)
- Modify: [drawer.blade.php](file:///workspace/resources/views/components/drawer.blade.php)
- Modify: [dropdown.blade.php](file:///workspace/resources/views/components/dropdown.blade.php)
- Modify: [tabs.blade.php](file:///workspace/resources/views/components/tabs.blade.php)
- Modify: [toast.blade.php](file:///workspace/resources/views/components/toast.blade.php)

**Livewire views relying on bundled deps**
- Modify: `resources/views/livewire/date-picker.blade.php`
- Modify: `resources/views/livewire/rich-text-editor.blade.php`

**Docs + tests**
- Modify: `docs/components/livewire/date-picker.md`
- Modify: `docs/components/livewire/rich-text-editor.md`
- Create: `tests/Feature/AssetsComponentTest.php`
- Modify/Create: `tests/Feature/Components/OverlayContractRenderTest.php`

---

### Task 1: Create branch + baseline checks

- [ ] **Step 1: Create feature branch**
Run:
```bash
git checkout main
git pull --ff-only
git checkout -b feature/overlay-contract-and-livewire-assets
```

- [ ] **Step 2: Baseline tests**
Run:
```bash
composer install --no-interaction --no-progress --prefer-dist
vendor/bin/phpunit
vendor/bin/phpstan analyse --no-progress --memory-limit=1G
```
Expected: PASS.

---

### Task 2: Add bundled dependencies + JS entry

**Files:** [package.json](file:///workspace/package.json), [resources/js/bcomponents.js](file:///workspace/resources/js/bcomponents.js)

- [ ] **Step 1: Add dependencies**
Edit `package.json` to include:
- `flatpickr`
- `@ckeditor/ckeditor5-build-classic`

- [ ] **Step 2: Create JS entry that initializes Alpine + registers modules**
Create `resources/js/bcomponents.js` that:
- imports Alpine, sets `window.Alpine`, starts it once
- imports flatpickr and assigns `window.flatpickr`
- imports ClassicEditor and assigns `window.ClassicEditor`
- registers Alpine data helpers:
  - `bOverlay({ initialOpen, static })` used by modal/drawer
  - `bDropdown({ initialOpen })`
  - `bTabs({ initial })`
  - `bToast({ duration, dismissible })`

---

### Task 3: Configure Vite build to output `dist/js/bcomponents.js` (non-hashed)

**Files:** [vite.config.js](file:///workspace/vite.config.js)

- [ ] **Step 1: Add `resources/js/bcomponents.js` as build input**
Update laravel-vite-plugin `input` list to include `resources/js/bcomponents.js`.

- [ ] **Step 2: Ensure deterministic output filenames**
Set `build.rollupOptions.output`:
- `entryFileNames: 'js/[name].js'`
- `chunkFileNames: 'js/[name].js'`
- `assetFileNames: 'assets/[name][extname]'`

- [ ] **Step 3: Build assets and commit `dist/js/bcomponents.js`**
Run:
```bash
npm ci --no-audit --no-fund
npm run build
```
Expected: `dist/js/bcomponents.js` exists.

Commit the generated dist file(s).

---

### Task 4: Publish and load the new bundle (Option 1)

**Files:** [BComponentsServiceProvider.php](file:///workspace/src/BComponentsServiceProvider.php), [assets.blade.php](file:///workspace/resources/views/components/assets.blade.php)

- [ ] **Step 1: Publish `dist/js` instead of raw `resources/js`**
Update the `bcomponents-assets` publish group to publish:
- `__DIR__ . '/../dist/js'` → `public/vendor/bcomponents/js`
- keep publishing `resources/css` to `public/vendor/bcomponents/css`

- [ ] **Step 2: Update `<x-b-assets />` to load `bcomponents.js`**
Change script tag to:
```blade
<script src="{{ asset('vendor/bcomponents/js/bcomponents.js') }}" defer></script>
```

- [ ] **Step 3: Add test for assets output**
Create `tests/Feature/AssetsComponentTest.php` verifying the rendered HTML includes:
- `vendor/bcomponents/css/bcomponents.css`
- `vendor/bcomponents/js/bcomponents.js`

---

### Task 5: Standardize overlays to shared contract

**Files:** overlay Blade views listed above

- [ ] **Step 1: Modal + Drawer**
Refactor their Alpine blocks to:
- use the same `bOverlay(...)` data shape
- keep existing event names (`open-modal/close-modal`, `open-drawer/close-drawer`)
- consistent ESC behavior (no close when `static`)
- focus trap logic shared (first/last/next/prev focusable)

- [ ] **Step 2: Dropdown**
Standardize:
- `aria-expanded` on trigger
- ESC close, click-away close
- optionally accept `name` and support `open-dropdown/close-dropdown` when present

- [ ] **Step 3: Tabs**
Add/confirm:
- roles (`tablist`, `tab`, `tabpanel`)
- roving tabindex + arrow keys + Home/End

- [ ] **Step 4: Toast**
Standardize:
- close button focus styles tokenized
- ESC close (if dismissible)
- pause timer on hover/focus (optional, but preferred)

- [ ] **Step 5: Add render contract tests**
Create/extend `tests/Feature/Components/OverlayContractRenderTest.php` asserting:
- presence of `@keydown.escape` markers
- required aria attributes/roles

---

### Task 6: Livewire components rely on bundled deps (supported)

**Files:** Livewire views + docs

- [ ] **Step 1: Date Picker (Livewire)**
Update the Livewire view to use `window.flatpickr` (bundled) and document:
- “Add `<x-b-assets />` to your layout”

- [ ] **Step 2: Rich Text Editor (Livewire)**
Remove dynamic script injection and assume `window.ClassicEditor` exists (bundled).

- [ ] **Step 3: Docs updates**
Update:
- `docs/components/livewire/date-picker.md`
- `docs/components/livewire/rich-text-editor.md`
to mark these as `supported` and specify no extra consumer JS steps beyond `<x-b-assets />`.

---

### Task 7: Verify + push

- [ ] **Step 1: Verify**
Run:
```bash
vendor/bin/phpunit
vendor/bin/phpstan analyse --no-progress --memory-limit=1G
```

- [ ] **Step 2: Ensure dist bundle exists and is tracked**
Run:
```bash
ls -la dist/js
git status --porcelain
```
Expected: clean working tree after commits.

- [ ] **Step 3: Push branch**
Run:
```bash
git push -u origin feature/overlay-contract-and-livewire-assets
```

