# bComponents Package Conceptual Architecture Spec

## Why
bComponents needs a Laravel-native conceptual architecture that stays stable while implementation details (views, recipes, assets, Livewire adapters) evolve. This reduces API drift, improves maintainability, and makes adoption easier across different Laravel applications.

## What Changes
- Define a layered conceptual architecture for the package (contract/render/styling/interaction/distribution).
- Define component family classification (static primitives, Alpine-interactive shells, Livewire-aware composites).
- Define a theming model based on semantic CSS variable tokens + class recipes (Tailwind v4 direction).
- Define supported consumption/distribution modes (zero-build, consumer source-build, hybrid; precompiled presets later).
- Define a testing model that does not rely on browser automation (CLI-only baseline).

## Impact
- Affected specs: package architecture, theming contract, component API consistency, distribution strategy, testing strategy.
- Affected code: service provider boot model and publish tags, view loading/override strategy, style recipe layer, optional Livewire adapter layer.

## ADDED Requirements

### Requirement: Architecture Document
The system SHALL provide an authoritative conceptual architecture document for bComponents in the repository.

#### Scenario: Developer onboarding
- **WHEN** a developer opens the repository
- **THEN** they can find the conceptual architecture document and understand package layers, responsibilities, and extension points without reading implementation code first.

### Requirement: Layered Core Model
The architecture SHALL define one conceptual core and multiple consumption modes.
- The conceptual core SHALL cover: component contract, styling recipes, token model, accessibility rules, attribute/slot conventions.
- Consumption modes SHALL be described as: zero-build server-only, consumer source-build, hybrid.

#### Scenario: Consumer chooses build strategy
- **WHEN** a consumer wants “no build”
- **THEN** the architecture describes how to use prebuilt/published assets and package Blade views.
- **WHEN** a consumer wants “full customization”
- **THEN** the architecture describes how to compile using the consumer’s Tailwind/Vite pipeline with package view scanning and token overrides.

### Requirement: Component Family Classification
The architecture SHALL classify components into families:
- Family A: Static Blade primitives (cache-friendly, minimal JS)
- Family B: Blade + Alpine interactive shells (local state, no server roundtrip)
- Family C: Livewire-aware composites (server-aware, stateful, higher integration cost)

#### Scenario: Component design decisions
- **WHEN** designing or reviewing a component
- **THEN** its family determines acceptable dependencies, state handling, and testing depth.

### Requirement: Theming Contract
The architecture SHALL define a Tailwind v4-aligned theming contract:
- Tokens SHALL be semantic (e.g. `primary`, `surface`, `border`, `text`, `focus`) and exposed via CSS variables.
- Component classes SHALL be produced by recipe builders that reference tokens (not hard-coded Tailwind palette values).
- Overrides SHALL be supported at multiple levels: preset switching, CSS variable overrides, view overrides.

#### Scenario: Theme override without vendor edits
- **WHEN** a consumer wants brand colors/fonts
- **THEN** they can override tokens (and optionally preset) without editing vendor views.

### Requirement: Registration and Overrides
The architecture SHALL specify:
- Provider-driven boot model as the authoritative integration point.
- View override model via `loadViewsFrom` and published override paths.
- Component registration strategy emphasizing namespace-based loading with optional ergonomic aliases.

#### Scenario: Consumer overrides a single view
- **WHEN** a consumer publishes and edits a component view
- **THEN** only that component changes without requiring copying unrelated templates.

### Requirement: Non-Browser Test Baseline
The architecture SHALL define a CLI-only test baseline:
- Contract tests (prop normalization, merge rules, recipe outputs)
- Render tests (Blade output structure, attributes/classes)
- Livewire tests (bindings, loading state, rerender safety) where applicable
- No browser automation is required for baseline verification.

#### Scenario: CI validation
- **WHEN** CI runs the package test suite
- **THEN** it validates the contract and rendering behavior without needing a browser runtime.

## MODIFIED Requirements

### Requirement: Documentation as Contract Surface
The package documentation SHALL be treated as part of the public contract:
- Component families, theming rules, and distribution modes SHALL be documented and kept consistent with releases.
- Changes to contract-level docs SHALL be treated as versioned changes.

## REMOVED Requirements

### Requirement: Single Mandatory Build Mode
**Reason**: Laravel applications differ widely; forcing a single frontend pipeline reduces adoption and increases friction.
**Migration**: Provide explicit instructions for zero-build and consumer-build modes, and define hybrid as the default mental model.

