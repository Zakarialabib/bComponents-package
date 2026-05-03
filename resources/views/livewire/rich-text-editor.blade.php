<div
    x-data="{
        content: @entangle('content').live,
        editor: null,
        init() {
            if (!window.ClassicEditor) return;
            this.initEditor();
        },
        initEditor() {
            const config = {
                placeholder: this.placeholder,
                toolbar: this.toolbar,
                ...this.config
            };
            
            window.ClassicEditor
                .create(this.$refs.editor, config)
                .then(editor => {
                    this.editor = editor;
                    editor.setData(this.content);
                    
                    editor.model.document.on('change:data', () => {
                        this.content = editor.getData();
                        $wire.updateContent(this.content);
                    });
                    
                    if (this.readOnly) {
                        editor.isReadOnly = true;
                    }
                })
                .catch(() => {});
        }
    }"
    x-init="init()"
    wire:ignore
    class="w-full"
>
    <div class="mb-2">
        <label class="block text-sm font-medium text-[color:var(--b-color-text)]">
            {{ $label ?? '' }}
        </label>
        
        <div 
            x-ref="editor"
            class="mt-1 block w-full rounded-[var(--b-radius-md)] border border-[color:var(--b-color-border)] shadow-sm focus:border-[color:var(--b-color-primary)] focus:ring-[color:var(--b-color-primary)]"
            style="min-height: {{ $height }}"
        ></div>
        
        @error('content')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
