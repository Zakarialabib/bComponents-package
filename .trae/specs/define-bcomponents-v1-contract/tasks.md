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

- [ ] Task 5: Normalize v1 core Blade components to the new contract
  - [x] Button: align props to variant/size/tone/disabled/loading/icon + class merging rules
  - [ ] Input/Textarea/Select/Checkbox/Radio/Toggle: align props and validation states
  - [ ] Alert/Card/Modal/Dropdown/Tabs: align props, slots, and accessibility expectations

- [ ] Task 6: Add documentation metadata scaffolding
  - [ ] Define a metadata format and store metadata for each v1 core component
  - [ ] Provide a retrieval API for docs/portal consumption

- [ ] Task 7: Add automated test baseline
  - [ ] Blade render tests for each v1 core component (smoke + attribute merge checks)
  - [ ] Selected Livewire integration tests for Livewire-aware components

- [x] Task 8: Update package documentation for v1 contracts
  - [x] Update README usage examples to match the new prop contract
  - [x] Document Tailwind v4 content paths and theming override approach

# Task Dependencies
- Task 2 depends on Task 1
- Task 4 depends on Task 1
- Task 5 depends on Task 2 and Task 4
- Task 6 depends on Task 5
- Task 7 depends on Task 5
- Task 8 depends on Task 1, Task 3, and Task 5
