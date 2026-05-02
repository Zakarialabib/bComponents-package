# Tasks
- [ ] Task 1: Add conceptual architecture documentation
  - [ ] Create a single authoritative doc (e.g. `docs/architecture/bcomponents-conceptual-architecture.md`) containing:
    - provider-driven boot model
    - layered architecture (contract/render/styling/interaction/distribution)
    - component families A/B/C and how to classify components
    - theming contract (semantic tokens + recipes + override levels)
    - consumption modes (zero-build, consumer source-build, hybrid)
    - Livewire compatibility labels and guidance
    - performance principles (render/hydration/asset/build)
    - testing model (CLI-only baseline; no browser)

- [ ] Task 2: Wire docs entry points
  - [ ] Add README link(s) to the conceptual architecture doc
  - [ ] Ensure any existing docs index (if present) references the new doc

- [ ] Task 3: Audit current implementation against the conceptual architecture
  - [ ] Create a short “alignment checklist” section in the doc that maps existing directories/files to each architecture layer
  - [ ] List gaps as explicit follow-up items (no implementation in this task)

- [ ] Task 4: Add/adjust CLI-only verification commands in docs
  - [ ] Document the baseline verification commands (e.g. `vendor/bin/phpunit`, `vendor/bin/phpstan`)
  - [ ] Ensure instructions do not require a web browser

# Task Dependencies
- Task 2 depends on Task 1
- Task 3 depends on Task 1
- Task 4 depends on Task 1

