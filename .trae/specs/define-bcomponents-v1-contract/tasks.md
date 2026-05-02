# Tasks
- [x] Task 1: Establish the new configuration contract
  - [x] Replace current `config/bcomponents.php` with the minimal v1 schema (prefix/theme/components/assets/livewire/docs)
  - [x] Add migration notes to README for renamed/removed keys (BREAKING)

- [x] Task 2: Introduce a component registry layer
  - [x] Create registry class responsible for alias → class mapping and enablement checks
  - [x] Refactor service provider to register components via the registry and config prefix

- [x] Task 3: Add Tailwind v4 token-based theme assets
  - [x] Create package CSS entrypoint that defines base + semantic tokens via CSS variables
  - [x] Add at least one default theme preset and dark-mode rules
  - [x] Ensure assets can be published and optionally included (config-driven)

- [x] Task 4: Add style recipe utilities
  - [x] Implement recipe builders for button + input + surface primitives (pure PHP)
  - [x] Provide a stable API for recipe inputs: variant/size/tone/state

- [x] Task 5: Normalize v1 core Blade components to the new contract
  - [x] Button: align props to variant/size/tone/disabled/loading/icon + class merging rules
  - [x] Input/Textarea/Select/Checkbox/Radio/Toggle: align props and validation states
  - [x] Alert/Card/Modal/Dropdown/Tabs: align props, slots, and accessibility expectations
  - [x] Document canonical vs legacy prop aliases per Tier 1 component (deprecation layer)

- [x] Task 6: Add documentation metadata scaffolding
  - [x] Define a metadata format and store metadata for each v1 core component
  - [x] Provide a retrieval API for docs/portal consumption

- [x] Task 7: Add automated test baseline
  - [x] Blade render tests for each v1 core component (smoke + attribute merge checks)
  - [x] Selected Livewire integration tests for Livewire-aware components

- [x] Task 8: Update package documentation for v1 contracts
  - [x] Update README usage examples to match the new prop contract
  - [x] Document Tailwind v4 content paths and theming override approach

- [x] Task 9: Stabilize architecture drift (post-contract cleanup)
  - [x] Remove stale old-architecture references from BladeComponentManager (e.g. reads of removed keys like `default_classes`, `css_framework`)
  - [x] Add a regression test that fails if runtime code references removed keys (string scan test or targeted unit)
  - [x] Define and apply one canonical package view root; remove redundant view loading paths in the service provider
  - [x] Ensure view override behavior uses standard Laravel conventions (publishable views under `resources/views/vendor/bcomponents`)

- [x] Task 10: Simplify BaseComponent (reduce “second framework” risk)
  - [x] Audit which components rely on BaseComponent custom prop/attribute hydration
  - [x] Reduce BaseComponent to shared package behavior:
    - [x] keep attribute utilities (class merge, attribute getters) if needed
    - [x] remove/avoid prop hydration that overrides constructor-provided values
    - [x] ensure typed props and kebab-case mapping behave predictably
  - [x] Add tests for typed props + kebab/camel mapping and “constructor value not overwritten” regression

- [x] Task 11: Package quality gates (release readiness)
  - [x] Add a CI workflow that runs `composer install` + `vendor/bin/phpunit` on supported PHP/Laravel versions
  - [x] Add a minimal static analysis baseline (only if tooling is present or explicitly added)
  - [x] Add/initialize a versioned changelog and document deprecation policy (legacy prop alias timeline)

# Task Dependencies
- Task 2 depends on Task 1
- Task 4 depends on Task 1
- Task 5 depends on Task 2 and Task 4
- Task 6 depends on Task 5
- Task 7 depends on Task 5
- Task 8 depends on Task 1, Task 3, and Task 5
- Task 9 depends on Task 1 and Task 2
- Task 10 depends on Task 5 (or may be done in parallel if it does not break Tier 1 components)
- Task 11 depends on Task 7
