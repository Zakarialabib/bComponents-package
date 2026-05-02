# Tasks
- [x] Task 1: Add conceptual architecture documentation
  - [x] Create a single authoritative doc (e.g. `docs/architecture/bcomponents-conceptual-architecture.md`) containing:
    - provider-driven boot model
    - layered architecture (contract/render/styling/interaction/distribution)
    - component families A/B/C and how to classify components
    - theming contract (semantic tokens + recipes + override levels)
    - consumption modes (zero-build, consumer source-build, hybrid)
    - Livewire compatibility labels and guidance
    - performance principles (render/hydration/asset/build)
    - testing model (CLI-only baseline; no browser)

- [x] Task 2: Wire docs entry points
  - [x] Add README link(s) to the conceptual architecture doc
  - [x] Ensure any existing docs index (if present) references the new doc

- [x] Task 3: Audit current implementation against the conceptual architecture
  - [x] Create a short “alignment checklist” section in the doc that maps existing directories/files to each architecture layer
  - [x] List gaps as explicit follow-up items (no implementation in this task)

- [x] Task 4: Add/adjust CLI-only verification commands in docs
  - [x] Document the baseline verification commands (e.g. `vendor/bin/phpunit`, `vendor/bin/phpstan`)
  - [x] Ensure instructions do not require a web browser

# Task Dependencies
- Task 2 depends on Task 1
- Task 3 depends on Task 1
- Task 4 depends on Task 1
