# bComponents v1 Contract & Architecture Spec

## Why
bComponents already ships useful Blade and Livewire UI building blocks, but its public API, theming contract, and internal architecture need clearer boundaries to remain stable and maintainable as the component inventory grows.

## What Changes
- Introduce a registration/registry layer to centralize Blade component registration and to support enable/disable and prefixing consistently.
- Define a small, stable component contract (props naming + attribute merging rules) and apply it to the v1 core component set.
- Adopt a Tailwind v4–native theming approach based on CSS variables (tokens) plus PHP-side class “recipes”.
- Add a metadata layer for documentation/portal readiness (component props/slots/compat notes).
- Add a test baseline (render tests + selected Livewire integration tests) for supported Laravel/Livewire versions.
- **BREAKING**: Replace current config surface (e.g. `default_classes`, `css_framework`) with a minimal, versionable config contract designed for Tailwind v4.
- Stabilize the architecture by removing stale “previous generation” behavior (e.g. managers referencing removed config keys).
- Simplify `BaseComponent` so it provides shared package behaviors, not a second prop/attribute framework parallel to Laravel.
- Define an explicit deprecation layer for legacy prop aliases (migration bridge) and document canonical props for Tier 1.
- Standardize a single canonical package view path and rely on Laravel’s standard view override conventions.
- Add “package quality gates”: CI workflow, a minimal static-analysis baseline, and a versioned changelog process.

## Impact
- Affected specs: component contract consistency, theming strategy, registration mechanism, docs metadata, test baseline.
- Affected code: [BComponentsServiceProvider.php](file:///workspace/src/BComponentsServiceProvider.php), [BladeComponentManager.php](file:///workspace/src/BladeComponentManager.php), [bcomponents.php](file:///workspace/config/bcomponents.php), component PHP classes under [src/Components](file:///workspace/src/Components), Blade views under [resources/views/components](file:///workspace/resources/views/components) and [src/resources/views/components](file:///workspace/src/resources/views/components).

## ADDED Requirements

### Requirement: Public Component Prefix
The system SHALL register Blade components with a configurable prefix.
- Default prefix SHALL be `b`.
- Prefix SHALL be configurable via `config('bcomponents.prefix')`.

#### Scenario: Install uses default prefix
- **WHEN** the package is installed with no config overrides
- **THEN** `<x-b-button>` resolves to the package button component.

#### Scenario: Install uses custom prefix
- **WHEN** a consumer sets `bcomponents.prefix = "ui"`
- **THEN** `<x-ui-button>` resolves to the package button component.

### Requirement: Component Registry
The system SHALL centralize component registration in a registry/manager object.
- The registry SHALL expose a single source of truth for component aliases.
- The registry SHALL support component enablement checks via config.

#### Scenario: Disabled component
- **WHEN** a consumer disables a component in config
- **THEN** the component SHALL not be registered (or SHALL fail with a clear error on use, depending on chosen strategy during implementation).

### Requirement: Livewire Component Registration
The system SHALL register packaged Livewire components when Livewire is enabled.
- Registration SHALL be gated by `config('bcomponents.livewire.enabled')`.
- Livewire component names SHALL use the same prefix as Blade components (default `b`), e.g. `b-modal`, `b-dropdown`.

#### Scenario: Livewire enabled
- **WHEN** Livewire is installed and `bcomponents.livewire.enabled=true`
- **THEN** `<livewire:b-modal />` and other registered tags resolve to the package Livewire components.

### Requirement: Core Component Contract
The system SHALL define stable prop naming conventions for Tier 1–3 components.
- Standard props (where applicable) SHALL include: `variant`, `size`, `tone`, `disabled`, `loading`, `icon`, `class`.
- Boolean props SHALL behave predictably (truthy enables behavior; absent/false disables).
- Components SHALL standardize attribute merging rules (e.g. classes merged without clobbering user-provided classes).

#### Scenario: Consumer passes custom classes
- **WHEN** a consumer sets `class="..."` on a bComponents element
- **THEN** consumer classes SHALL be preserved and merged with the component’s computed classes.

### Requirement: Tailwind v4 Theme Tokens (CSS Variables)
The system SHALL expose theme tokens via CSS variables.
- Tokens SHALL include (at minimum) families for color, radius, shadow, and control spacing.
- The package SHALL ship at least one default theme preset.
- Dark mode SHALL be supported by the default preset.
- Consumers SHALL be able to override tokens by publishing assets and/or by providing a `tokens_path` override.

#### Scenario: Default theme preset
- **WHEN** a consumer includes the package CSS
- **THEN** default tokens SHALL be applied to components without additional configuration.

#### Scenario: Consumer custom tokens
- **WHEN** a consumer configures a tokens override
- **THEN** components SHALL reflect the new token values without modifying vendor views.

### Requirement: Style Recipes
The system SHALL compute component classes from centralized “recipe” builders.
- Recipes SHALL exist per component family (e.g. button, input, surface).
- Recipes SHALL be testable as pure PHP logic (given props → returns class string/array).

#### Scenario: Variant switch changes classes
- **WHEN** a button uses `variant="outline"` vs `variant="solid"`
- **THEN** output classes SHALL differ according to the recipe rules.

### Requirement: Documentation Metadata
The system SHALL provide component metadata for documentation and portal generation.
- Metadata SHALL include: display name, category, props, slots, variants, accessibility notes, compatibility notes, examples.
- Metadata SHALL live in a dedicated support layer and SHALL be versionable.

#### Scenario: Metadata retrieval
- **WHEN** the documentation system queries package metadata
- **THEN** it receives structured data for each shipped component.

### Requirement: Test Baseline
The system SHALL include automated tests covering:
- Blade render correctness for Tier 1–3 components (smoke + attribute merge assertions).
- Selected Livewire integration behaviors for Livewire-aware components.

#### Scenario: Render tests
- **WHEN** tests are executed
- **THEN** each v1 core component renders without errors and includes expected attributes/classes.

### Requirement: No Stale Config References
The system SHALL not reference removed or deprecated config keys in runtime code paths.

#### Scenario: Config contract is minimal
- **WHEN** the consumer uses the new `config/bcomponents.php` schema
- **THEN** no package class attempts to read `default_classes`, `css_framework`, or other removed keys.

### Requirement: Canonical View Root
The system SHALL ship one canonical package view root and rely on standard Laravel override conventions.
- The canonical root SHALL be the only path registered with `loadViewsFrom` for the `bcomponents` namespace.
- Consumer overrides SHALL work via `resources/views/vendor/bcomponents` without custom conditional logic.

#### Scenario: Consumer overrides a single view
- **WHEN** a consumer publishes and edits `resources/views/vendor/bcomponents/components/button.blade.php`
- **THEN** `<x-b-button>` renders the overridden view without requiring changes to package internals.

### Requirement: BaseComponent Scope
`BaseComponent` SHALL provide shared package behavior only, and SHALL avoid re-implementing Laravel’s component prop system.

The BaseComponent SHALL:
- support consistent attribute class merge behavior used by package views
- optionally provide shared helpers (e.g. `getComponentAttribute`, event init hook), as long as they do not alter Laravel’s native prop behavior

The BaseComponent SHALL NOT:
- invent a second “props hydration” system that competes with constructor props
- guess views in ways that hide missing views (prefer explicit view names)

#### Scenario: Typed constructor props behave predictably
- **WHEN** a component uses typed constructor args
- **THEN** values arrive exactly as passed by Blade, without being overwritten by default hydration.

### Requirement: Deprecation Layer for Legacy Props
The system SHALL treat legacy prop names as a temporary compatibility layer, not the canonical public API.
- Canonical Tier 1 props SHALL be documented (e.g. `variant/size/tone/disabled/loading/fullWidth/iconOnly`).
- Legacy aliases (e.g. `isDisabled/isLoading/isBlock/isIconOnly/color`) SHALL be documented as deprecated.
- Deprecated aliases SHOULD emit `E_USER_DEPRECATED` warnings in non-production environments (config-gated).

#### Scenario: Legacy prop alias is used
- **WHEN** a consumer passes a legacy prop (e.g. `isDisabled`)
- **THEN** the component behaves as the canonical prop would (e.g. sets `disabled`) and the alias is documented as deprecated.

### Requirement: Package Quality Gates
The system SHALL provide baseline maturity tooling for release readiness:
- a CI workflow that runs tests on supported PHP/Laravel matrices
- a minimal static analysis baseline (tool choice constrained to what the repo already uses or will add explicitly)
- a versioned changelog with deprecation notes

#### Scenario: CI verification
- **WHEN** a PR is opened
- **THEN** CI runs and reports pass/fail for tests and static analysis.

## MODIFIED Requirements

### Requirement: Configuration Contract (**BREAKING**)
The system SHALL replace the current configuration schema with a minimal contract:
- `prefix`
- `theme`: `preset`, `dark_mode`, `tokens_path`
- `components`: `enabled`
- `assets`: `include_css`, `include_js`
- `livewire`: `enabled`, `compatibility_mode`
- `docs`: `metadata`

Migration guidance:
- Existing `default_classes` SHALL be replaced by recipe logic and/or theme tokens.
- Existing `css_framework` SHALL be removed; Tailwind v4 is the supported baseline.

### Requirement: View Loading Strategy
The system SHALL standardize view loading and avoid ambiguous multiple-view roots.
- Only one package view root SHALL be loaded for the `bcomponents` namespace.
- Any legacy view roots MUST be removed or migrated.

## REMOVED Requirements

### Requirement: Multi-Framework Styling
**Reason**: Tailwind v4-native tokens and recipes require a single consistent styling paradigm for predictable contracts.
**Migration**: Consumers using other frameworks should treat bComponents as Tailwind-only; no compatibility layer will be maintained in v1.
