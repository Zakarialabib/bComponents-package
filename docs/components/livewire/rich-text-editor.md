# rich-text-editor (Livewire)

## Tag
- `<livewire:b-rich-text-editor />`

## Status
- `supported`

## Public Props
- `mixed $content`
- `mixed $config`
- `mixed $height`
- `mixed $placeholder`
- `mixed $readOnly`
- `mixed $toolbar`

## Listeners / Events
- `contentUpdated → updateContent`
- `refresh → $refresh`

## Dependencies
- Alpine.js
- CKEditor (bundled)

Requirements:
- Your layout MUST include `<x-b-assets />` so `ClassicEditor` is available.

## Accessibility
- (no explicit markers detected in view)

## Usage Example

```blade
<x-b-assets />

<livewire:b-rich-text-editor />
```

## Code
- Class: Zakarialabib\BComponents\Livewire\RichTextEditorComponent
- View: /workspace/resources/views/livewire/rich-text-editor.blade.php
