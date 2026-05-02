# Component Catalog & Contract Hardening Spec

## Why
bComponents currently ships many registered components, but consumers do not have a complete, copy/paste-safe component catalog, and the registry can expose components whose views are missing. This creates adoption friction and runtime failures.

## What Changes
- Create a complete per-component documentation catalog under `docs/components/` (one page per component) with a stable template and an index page.
- Update the public README to be a high-level entry point that links to the catalog and stays contract-accurate.
- Ensure component registry integrity: every registered Blade component alias has a resolvable view, or is removed from the registry (**BREAKING** if consumers used it).
- Add automated guards to prevent regressions (missing views, missing catalog pages, missing metadata coverage).

## Impact
- Affected specs: documentation-as-contract, component registry integrity, metadata completeness, release readiness.
- Affected code:
  - Blade registry and view layer: `src/Support/ComponentRegistry.php`, `resources/views/components/*`
  - Core components with missing views: `src/Components/BreadcrumbComponent.php`, `src/Components/LoadingComponent.php`
  - Docs and catalog: `readme.md`, `docs/components/*`, `docs/components/index.md`
  - Metadata: `src/Support/Metadata/ComponentMetadataRepository.php`
  - Tests: `tests/Feature/*`

## ADDED Requirements

### Requirement: Component Catalog Pages
The system SHALL provide per-component catalog pages for every publicly registered component.
- Each component page SHALL document:
  - Tag name (`<x-b-...>` or `<livewire:b-...>`), status (stable / legacy / experimental)
  - Props (canonical + legacy aliases, with default values)
  - Slots (and their purpose)
  - Events / JS dependencies (Alpine, Flatpickr, CKEditor, etc.) where applicable
  - Accessibility notes (roles, aria attributes, keyboard behavior)
  - Copy/paste usage examples
  - Code pointers to class + view files

#### Scenario: Developer adopts a component
- **WHEN** a developer opens `docs/components/<component>.md`
- **THEN** they can implement the component in an app without guessing prop names or required JS dependencies.

### Requirement: Component Catalog Index
The system SHALL provide a catalog index page under `docs/components/index.md`.
- The index SHALL group components by family (primitives / layout / overlays / tables / livewire / legacy).
- The index SHALL link to each component page.

#### Scenario: Developer discovers what exists
- **WHEN** a developer navigates to the catalog index
- **THEN** they can see all available components and click through to details.

### Requirement: Registry View Integrity
The system SHALL guarantee that every Blade component registered in `ComponentRegistry` has a resolvable view under the canonical package view root.

#### Scenario: Consumer uses any registered tag
- **WHEN** a consumer uses any `<x-b-*>` component alias from the registry
- **THEN** rendering SHALL not fail due to a missing component view.

### Requirement: Automated Integrity Guards
The system SHALL include automated checks that fail CI when:
- a component alias exists in the registry but has no view template
- a component alias exists in the registry but has no catalog page
- a component alias exists in the registry but is missing metadata entry (when metadata is enabled)

#### Scenario: Regression introduced
- **WHEN** a contributor registers a new component alias without adding required assets/docs
- **THEN** the test suite SHALL fail with a clear message.

## MODIFIED Requirements

### Requirement: Documentation as Contract Surface
Documentation SHALL be treated as part of the public contract and be kept consistent with shipped behavior.
- The README SHALL only include contract-accurate examples and SHALL link to the full catalog instead of attempting to fully document every component inline.

## REMOVED Requirements

### Requirement: Implicit Component Availability
**Reason**: Implicitly registering aliases without guaranteeing a view/correct docs causes runtime failures.
**Migration**: Either provide canonical views for missing components or remove those aliases until implemented.

