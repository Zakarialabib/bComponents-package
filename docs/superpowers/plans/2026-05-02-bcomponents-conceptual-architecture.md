# bComponents Conceptual Architecture Documentation Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Add an authoritative conceptual architecture document for bComponents and wire it into existing docs/README, with CLI-only verification guidance (no web browser).

**Architecture:** Documentation-only change. Create a single source-of-truth architecture document, link it from README, add an “architecture-to-code mapping” section, and document CLI verification commands.

**Tech Stack:** Markdown docs, Laravel package conventions, PHPUnit/Testbench, PHPStan.

---

## File Map (Create/Modify)

**Create**
- `docs/architecture/bcomponents-conceptual-architecture.md`

**Modify**
- `readme.md`
- `.trae/specs/define-bcomponents-conceptual-architecture/tasks.md` (check completed items)
- `.trae/specs/define-bcomponents-conceptual-architecture/checklist.md` (check passed checkpoints)

---

### Task 1: Create the conceptual architecture doc

**Files:**
- Create: `docs/architecture/bcomponents-conceptual-architecture.md`

- [ ] **Step 1: Write the doc file with all required sections**

Create `docs/architecture/bcomponents-conceptual-architecture.md` with the following content:

```md
# bComponents Package Conceptual Architecture

## Purpose
bComponents is a Blade-first UI package with optional Livewire + Alpine enhancements. This document defines the stable conceptual architecture that guides implementation, versioning, testing, and adoption across different Laravel applications.

This document is intentionally framework-aligned:
- Laravel package integration flows through a service provider.
- Blade templates compile to cached PHP.
- Livewire enhances Blade; it should not replace the core rendering model.

## Core Model: One Core, Multiple Consumption Modes

### One conceptual core
The core owns:
- component contract (props/slots/attribute merge rules)
- style recipes
- semantic theme token model
- accessibility rules
- Livewire-safe behavior guarantees (where applicable)

### Multiple consumption modes
The same package supports:
- **Mode 1: Zero-build (server-only)**: install via Composer, publish assets, use `<x-b-*>` immediately
- **Mode 2: Consumer source-build**: consumer compiles Tailwind output using their Vite/Tailwind pipeline and scans package views
- **Mode 3: Hybrid**: defaults are prebuilt/published, but consumers can opt into deeper customization

## Layered Architecture

### Layer 1: Contract layer (most stable)
Defines:
- prop naming conventions (`variant`, `size`, `tone`, `disabled`, `loading`, `class`, …)
- boolean semantics (absent/false disables; true enables)
- attribute merge rules (consumer attributes/classes are preserved)
- slot conventions and naming
- accessibility expectations per component family

Contract stability matters more than internal markup. Visual improvements should not require contract breaks.

### Layer 2: Render layer (Blade output)
Responsibilities:
- Blade views (class-based and/or anonymous)
- slot composition patterns
- minimal duplication while keeping overrides safe

Guidance:
- use class-based components where normalization/computation is required
- use anonymous components for simple structural wrappers
- keep overrides localized (avoid deep hidden partial trees)

### Layer 3: Styling layer (tokens + recipes)
Responsibilities:
- semantic CSS variables (tokens)
- recipe builders that map contract inputs → class strings
- dark-mode behavior via tokens

Rules:
- prefer semantic tokens (e.g. `--b-color-primary`, `--b-color-surface`) over Tailwind palette names
- recipes SHOULD reference tokens (Tailwind v4 arbitrary values) rather than hard-coded palette classes
- consumers need multiple override levels:
  - preset switching (config)
  - CSS variable overrides
  - published view overrides (last resort)

### Layer 4: Interaction layer (progressive enhancement)
Responsibilities:
- native HTML semantics first
- Alpine for local UI state (open/close, tabs, disclosure, focus helpers)
- Livewire for server-backed state

Rules:
- primitives should be Livewire-safe without special handling
- Alpine behavior must be rerender-safe under Livewire
- avoid heavy JS dependencies by default

### Layer 5: Distribution layer (how users adopt)
Responsibilities:
- publish tags and resource paths
- support the 3 primary consumption modes
- documentation that makes build choices explicit

## Component Families (Delivery Strategy)

### Family A: Static Blade primitives
Examples: button, badge, input, select, card, divider

Characteristics:
- minimal JS
- cache-friendly and cheap to render
- stable API surface

### Family B: Blade + Alpine interactive shells
Examples: dropdown, tabs, modal shell, drawer, accordion

Characteristics:
- local state; no server roundtrip required
- lightweight keyboard behavior where applicable
- rerender-safe under Livewire (when used inside Livewire)

### Family C: Livewire-aware composites
Examples: data table, async select, file upload shell, modal controller

Characteristics:
- stateful; higher integration complexity
- Livewire compatibility notes are mandatory
- more extensive test coverage required

## Registration Strategy
Primary:
- register components via a centralized registry in the service provider
- maintain a stable Blade prefix (`b` → `<x-b-*>`)

Optional:
- explicit aliases for flagship shortcuts (only when necessary)

## View Override Strategy
Consumer override is a feature:
- package uses `loadViewsFrom` so `resources/views/vendor/...` can override package templates
- publish tags must be clear and stable
- override directories should mirror component names to keep changes localized

## Theming Strategy (Tailwind v4 aligned)

### Token model
Use CSS variables for:
- base tokens (radius, shadows, spacing, fonts)
- semantic tokens (primary, surface, border, text, focus)

### Recipes
Recipes map:
`variant + size + tone + state` → class strings that reference tokens

### Override levels
1. config preset switching
2. CSS variable overrides
3. published view overrides

## Livewire Compatibility Labels
Each component should carry one of these labels in docs/metadata:
- Blade only
- Blade + Alpine
- Livewire safe
- Livewire optimized

## Performance Principles
- Render: keep trees shallow, avoid unnecessary nesting
- Hydration: Alpine for local state; Livewire only when server state matters
- Assets: minimal JS baseline; optional enhancements behind opt-in usage
- Build: document Tailwind scan paths to avoid bloat and missed classes

## Testing Model (CLI-only baseline; no browser)

### Contract tests
- prop normalization
- attribute merge behavior
- recipe outputs for variants/sizes/states

### Render tests
- Blade render smoke tests for each core component
- assert critical attributes/classes/slots output

### Livewire tests (where relevant)
- wire:model/wire:click pass-through
- loading state behaviors
- rerender safety (no brittle DOM assumptions)

## Architecture-to-Code Mapping (current repo snapshot)

### Contract layer
- `src/Components/BaseComponent.php` (prop initialization + shared behavior)
- `src/Traits/*` (shared conventions)

### Render layer
- `resources/views/components/*` (public Blade component views)
- `src/resources/views/*` (legacy/alternate view tree; consider consolidation)

### Styling layer
- `resources/css/*` (token CSS and presets, if present)
- `src/Support/Styles/*` (recipe utilities, if present)

### Interaction layer
- `resources/js/*` (Alpine helpers, if present)
- Blade components’ Alpine directives in `resources/views/components/*`

### Distribution layer
- `src/BComponentsServiceProvider.php` (config merge, view loading, publish tags, component registration)
- `config/bcomponents.php` (public config contract)

## Alignment Checklist (gaps / follow-ups)
- Consolidate view sources: `resources/views` vs `src/resources/views` (define one authoritative tree)
- Ensure publish tags match actual directories (avoid publishing missing `public/` trees)
- Ensure Tailwind scan path docs match the actual shipped view paths
- Add metadata layer for component docs and compatibility labels
- Expand CLI test coverage to core components (not only smoke tests)
```

- [ ] **Step 2: Verify file exists**

Run:
```bash
test -f docs/architecture/bcomponents-conceptual-architecture.md && echo OK
```
Expected: `OK`

---

### Task 2: Wire README entry points

**Files:**
- Modify: `readme.md`

- [ ] **Step 1: Add an “Architecture” section with a link**

Insert after “Features” (or near top) a section:

```md
## Architecture

See [docs/architecture/bcomponents-conceptual-architecture.md](docs/architecture/bcomponents-conceptual-architecture.md).
```

- [ ] **Step 2: Verify link path exists**
Run:
```bash
test -f docs/architecture/bcomponents-conceptual-architecture.md && echo OK
```
Expected: `OK`

---

### Task 3: Audit alignment section (already included in doc)

**Files:**
- Modify (if needed): `docs/architecture/bcomponents-conceptual-architecture.md`

- [ ] **Step 1: Confirm the doc includes “Architecture-to-Code Mapping” and “Alignment Checklist”**
Run:
```bash
grep -n \"Architecture-to-Code Mapping\" -n docs/architecture/bcomponents-conceptual-architecture.md
grep -n \"Alignment Checklist\" -n docs/architecture/bcomponents-conceptual-architecture.md
```
Expected: both commands print at least one matching line.

---

### Task 4: Add CLI-only verification commands

**Files:**
- Modify: `docs/architecture/bcomponents-conceptual-architecture.md`

- [ ] **Step 1: Ensure the “Testing Model” section includes CLI commands**
Add a short subsection:

```md
### Baseline verification commands

```bash
composer test
vendor/bin/phpunit
vendor/bin/phpstan analyse
```
```

- [ ] **Step 2: Verify docs do not require a browser**
Search for browser requirements:
```bash
grep -RIn \"browser\\|playwright\\|cypress\" docs/architecture/bcomponents-conceptual-architecture.md || true
```
Expected: no matches.

---

## Self-Review (against spec)
- Covers layered architecture (contract/render/styling/interaction/distribution)
- Includes component family classification A/B/C
- Includes theming model (tokens + recipes + override levels)
- Includes consumption modes (zero-build, consumer-build, hybrid)
- Includes CLI-only testing guidance (explicitly no web browser)

