# Tasks
- [ ] Task 1: Establish the new configuration contract
  - [ ] Replace current `config/bcomponents.php` with the minimal v1 schema (prefix/theme/components/assets/livewire/docs)
  - [ ] Add migration notes to README for renamed/removed keys (BREAKING)

- [ ] Task 2: Introduce a component registry layer
  - [ ] Create registry class responsible for alias → class mapping and enablement checks
  - [ ] Refactor service provider to register components via the registry and config prefix

- [ ] Task 3: Add Tailwind v4 token-based theme assets
  - [ ] Create package CSS entrypoint that defines base + semantic tokens via CSS variables
  - [ ] Add at least one default theme preset and dark-mode rules
  - [ ] Ensure assets can be published and optionally included (config-driven)

- [ ] Task 4: Add style recipe utilities
  - [ ] Implement recipe builders for button + input + surface primitives (pure PHP)
  - [ ] Provide a stable API for recipe inputs: variant/size/tone/state

- [ ] Task 5: Normalize v1 core Blade components to the new contract
  - [ ] Button: align props to variant/size/tone/disabled/loading/icon + class merging rules
  - [ ] Input/Textarea/Select/Checkbox/Radio/Toggle: align props and validation states
  - [ ] Alert/Card/Modal/Dropdown/Tabs: align props, slots, and accessibility expectations

- [ ] Task 6: Add documentation metadata scaffolding
  - [ ] Define a metadata format and store metadata for each v1 core component
  - [ ] Provide a retrieval API for docs/portal consumption

- [ ] Task 7: Add automated test baseline
  - [ ] Blade render tests for each v1 core component (smoke + attribute merge checks)
  - [ ] Selected Livewire integration tests for Livewire-aware components

- [ ] Task 8: Update package documentation for v1 contracts
  - [ ] Update README usage examples to match the new prop contract
  - [ ] Document Tailwind v4 content paths and theming override approach

# Task Dependencies
- Task 2 depends on Task 1
- Task 4 depends on Task 1
- Task 5 depends on Task 2 and Task 4
- Task 6 depends on Task 5
- Task 7 depends on Task 5
- Task 8 depends on Task 1, Task 3, and Task 5

