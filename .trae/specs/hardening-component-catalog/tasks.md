# Tasks

- [x] Task 1: Confirm the public surface (registry + Livewire aliases) and define catalog taxonomy
  - [x] Inventory all Blade aliases from `ComponentRegistry::aliases()` and classify them into groups: primitives/layout/overlays/tables/livewire/legacy.
  - [x] Inventory all Livewire aliases registered by the service provider and classify them as experimental unless explicitly promoted.

- [x] Task 2: Fix registry integrity issues (no missing views)
  - [x] Identify any registered Blade components whose `view()` points to missing templates under `resources/views/components/`.
  - [x] For each missing-view component, choose one:
    - [x] Implement the missing view (minimal, consistent with v1 class merging conventions), or
    - [x] Remove the alias from `ComponentRegistry` (**BREAKING**) and document the removal/migration in README.
  - [x] Add/extend tests to ensure the fix holds.

- [x] Task 3: Update README to be a contract-accurate entry point
  - [x] Add a “Component Catalog” section linking to `docs/components/index.md`.
  - [x] Fix known drift points where README does not match code truth:
    - [x] `Alert` allowed `type` values
    - [x] `Card` footer API (slot vs prop)
    - [x] `Input` docs that reference non-existent props (`label/help/error`) — either remove or reframe via `form-group`
    - [x] Any other mismatches found in Task 1 inventory
  - [x] Ensure Tailwind scan paths and override instructions match the canonical view root.

- [x] Task 4: Build the component catalog (docs/components pages + index)
  - [x] Create `docs/components/index.md` with grouped links.
  - [x] Create one markdown page per Blade component alias documenting:
    - [x] Tag, status, props (canonical + legacy aliases), slots, a11y/behavior, usage examples, code references
  - [x] Create one markdown page per Livewire component documenting:
    - [x] Tag, public props, events, external JS dependencies, usage examples, code references

- [x] Task 5: Complete metadata coverage for the public surface
  - [x] Ensure `ComponentMetadataRepository` contains entries for every public component (Blade + Livewire where applicable).
  - [x] Mark compatibility labels consistently (Blade-only, Alpine required, Livewire).

- [x] Task 6: Add automated “no drift” guards
  - [x] Add a test that fails if any registry alias has a missing view.
  - [x] Add a test that fails if any registry alias has no `docs/components/<alias>.md` page (naming rules must be defined in Task 1; dot aliases like `table.header` must map deterministically).
  - [x] Add a test that fails if any registry alias is missing metadata entry (when docs metadata is enabled).

- [x] Task 7: Verification and release hygiene
  - [x] Run `vendor/bin/phpunit`
  - [x] Run `vendor/bin/phpstan analyse --no-progress --memory-limit=1G`
  - [x] Run grep checks to ensure README/docs do not mention removed config keys as active settings.

# Task Dependencies
- Task 2 depends on Task 1
- Task 3 depends on Task 1
- Task 4 depends on Task 1
- Task 5 depends on Task 1
- Task 6 depends on Task 2 and Task 4 and Task 5
- Task 7 depends on Task 2–6
