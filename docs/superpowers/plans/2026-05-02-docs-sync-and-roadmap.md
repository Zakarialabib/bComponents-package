# Docs Sync & Roadmap Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Update all markdown documentation to match the current codebase truth, reduce drift, and clearly communicate what is stable vs experimental vs legacy, including an explicit roadmap and gaps.

**Architecture:** Treat `readme.md` as the canonical public contract. Update remaining docs to either match shipped behavior or explicitly label content as legacy/experimental. Validate docs against the codebase using greps and runtime tests.

**Tech Stack:** Laravel package (PHP), Blade components, Livewire, Tailwind v4, PHPUnit (Orchestra Testbench), PHPStan.

---

## File Map (Modify/Create)

**Modify**
- [readme.md](file:///workspace/readme.md)
- [instructions.md](file:///workspace/instructions.md)
- [docs/header-and-footer.md](file:///workspace/docs/header-and-footer.md)
- [docs/superpowers/plans/2026-05-02-bcomponents-v1-contract.md](file:///workspace/docs/superpowers/plans/2026-05-02-bcomponents-v1-contract.md)
- [define-bcomponents-v1-contract/spec.md](file:///workspace/.trae/specs/define-bcomponents-v1-contract/spec.md) (keep aligned; internal but markdown)
- [define-bcomponents-v1-contract/tasks.md](file:///workspace/.trae/specs/define-bcomponents-v1-contract/tasks.md)
- [define-bcomponents-v1-contract/checklist.md](file:///workspace/.trae/specs/define-bcomponents-v1-contract/checklist.md)

**Create**
- (optional) `docs/roadmap.md` (only if README becomes too large; otherwise keep roadmap in README)

---

### Task 1: Branch & baseline verification

**Files:** none

- [ ] **Step 1: Checkout main and pull**
Run:
```bash
git checkout main
git pull --ff-only
```
Expected: Working tree clean, main up to date.

- [ ] **Step 2: Create a docs sync branch**
Run:
```bash
git checkout -b feature/docs-sync-codebase-truth
```
Expected: Branch created.

- [ ] **Step 3: Run baseline tests**
Run:
```bash
vendor/bin/phpunit
vendor/bin/phpstan analyse --no-progress --memory-limit=1G
```
Expected: Both pass before docs changes (guards against unrelated breakage).

---

### Task 2: Doc truth audit (identify drift via grep)

**Files:** none

- [ ] **Step 1: Grep for known outdated API signatures**
Run:
```bash
rg "<x-b-dropdown\\s+label=" -n .
rg "data-toggle=\\\"modal\\\"|data-target=" -n .
rg "<x-b-modal\\s+id=" -n .
rg "default_classes|css_framework" -n .
rg "livewire:livewire-modal|livewire:livewire-table" -n .
```
Expected: Identify all markdown lines that reference removed config keys or old component APIs.

- [ ] **Step 2: Capture the current “code truth” for Tier 1–3**
Manually confirm in code:
- Blade registry aliases and component names
- Canonical Blade component props (constructor args)
- Which Livewire components exist and whether they are meant to be public

Expected: A checklist of what docs must claim vs must not claim.

---

### Task 3: Rewrite README.md as the canonical contract (max info, with gaps/roadmap)

**Files:**
- Modify: [readme.md](file:///workspace/readme.md)

- [ ] **Step 1: Add “Status & Stability” section**
Include:
- Architecture state (post-stabilization)
- “Stable Blade components” vs “Experimental/Legacy” components
- Explicit compatibility: Laravel/PHP/Livewire/Tailwind versions (must match `composer.json`)

- [ ] **Step 2: Replace all examples that don’t match current Blade components**
Specifically ensure:
- Dropdown example uses current slot-based API (`trigger` + `content`) if that is the current package dropdown.
- Modal example uses the current API (`name`, `:show`, `maxWidth`, `static`) and does not mention Bootstrap-like data attributes.
- Livewire examples only mention components that exist and are configured correctly (or mark them as experimental).

- [ ] **Step 3: Add “Props: canonical vs legacy aliases”**
For Tier 1 components:
- list canonical props
- list deprecated legacy aliases and mapping
- state deprecation intent clearly (no timeline promises unless you want one)

- [ ] **Step 4: Add “Theming & Tailwind v4 integration”**
Include:
- Tailwind `content` paths for package views (canonical root)
- how to include tokens CSS
- how to override tokens (config `tokens_path` or published assets)

- [ ] **Step 5: Add “Roadmap & Gaps” (explicit)**
Include:
- gaps (a11y baselines, keyboard behavior, Livewire story maturity, remaining legacy view inventory)
- quality gates (CI + phpstan + tests) and what they cover today
- next planned stabilization steps

---

### Task 4: Update instructions.md to reflect current architecture and contributor workflow

**Files:**
- Modify: [instructions.md](file:///workspace/instructions.md)

- [ ] **Step 1: Replace outdated plan text**
Remove statements that conflict with current reality (e.g. “no need for documentation”).

- [ ] **Step 2: Add contributor guide**
Include:
- where components live
- how to add/normalize a component (constructor props + recipes + tokens)
- how view overrides work
- how to run tests + phpstan
- how to add metadata entries

---

### Task 5: Update docs/header-and-footer.md (truthful, and label legacy if not v1)

**Files:**
- Modify: [header-and-footer.md](file:///workspace/docs/header-and-footer.md)

- [ ] **Step 1: Verify current Header/Footer components**
Confirm:
- do these components exist in the registry?
- do these props exist today?

- [ ] **Step 2: Update doc to match shipped props**
If props differ:
- update property list and examples

- [ ] **Step 3: Add status header**
If not yet normalized to the v1 contract:
- label as “legacy/experimental” and point to v1 naming conventions

---

### Task 6: Update the older superpowers plan doc to reflect completion

**Files:**
- Modify: [2026-05-02-bcomponents-v1-contract.md](file:///workspace/docs/superpowers/plans/2026-05-02-bcomponents-v1-contract.md)

- [ ] **Step 1: Check off completed steps**
Mark all steps that have been completed in code as `[x]`.

- [ ] **Step 2: Add “Done / Remaining” summary**
Add a short summary so future readers can tell what remains without scanning.

---

### Task 7: Keep internal spec markdown aligned (no drift)

**Files:**
- Modify: [spec.md](file:///workspace/.trae/specs/define-bcomponents-v1-contract/spec.md)
- Modify: [tasks.md](file:///workspace/.trae/specs/define-bcomponents-v1-contract/tasks.md)
- Modify: [checklist.md](file:///workspace/.trae/specs/define-bcomponents-v1-contract/checklist.md)

- [ ] **Step 1: Ensure internal spec reflects current implementation**
If implementation moved beyond spec, update text (not code) so it stays truthful.

---

### Task 8: Verification, commit, push

**Files:** all changed docs

- [ ] **Step 1: Re-run automated verification**
Run:
```bash
vendor/bin/phpunit
vendor/bin/phpstan analyse --no-progress --memory-limit=1G
```
Expected: Both pass.

- [ ] **Step 2: Doc drift regression greps**
Run:
```bash
rg "default_classes|css_framework" -n .
rg "data-toggle=\\\"modal\\\"|data-target=" -n readme.md instructions.md docs -S
rg "<x-b-dropdown\\s+label=" -n readme.md instructions.md docs -S
```
Expected: No matches, or matches are explicitly marked as legacy with an explanation.

- [ ] **Step 3: Commit and push**
Run:
```bash
git add readme.md instructions.md docs .trae/specs
git commit -m "docs: sync markdown with codebase truth and roadmap"
git push -u origin feature/docs-sync-codebase-truth
```

