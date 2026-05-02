<div
    x-data="{
        content: @entangle('content').live,
        editor: null,
        init() {
            if (typeof ClassicEditor === 'undefined') {
                const script = document.createElement('script');
                script.src = 'https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js';
                script.onload = () => this.initEditor();
                document.head.appendChild(script);
            } else {
                this.initEditor();
            }
        },
        initEditor() {
            const config = {
                placeholder: this.placeholder,
                toolbar: this.toolbar,
                ...this.config
            };
            
            ClassicEditor
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
                .catch(error => {
                    console.error('CKEditor initialization failed:', error);
                });
        }
    }"
    x-init="init()"
    wire:ignore
    class="w-full"
>
    <div class="mb-2">
        <label class="block text-sm font-medium text-gray-700">
            {{ $label ?? '' }}
        </label>
        
        <div 
            x-ref="editor"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            style="min-height: {{ $height }}"
        ></div>
        
        @error('content')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

