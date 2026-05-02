<div
    x-data="{
        dragOver: false,
        files: @entangle('files').live,
        uploading: false,
        progress: 0,
        handleFileDrop(e) {
            if (e.dataTransfer.files.length > 0) {
                this.addFiles(e.dataTransfer.files);
            }
            this.dragOver = false;
        },
        handleFileInput(e) {
            this.addFiles(e.target.files);
        },
        addFiles(fileList) {
            // Check max files limit
            if (@js($maxFiles) !== null && this.files.length + fileList.length > @js($maxFiles)) {
                alert(`You can only upload a maximum of ${@js($maxFiles)} files.`);
                return;
            }
            
            // Add files to the Livewire property
            for (let i = 0; i < fileList.length; i++) {
                const file = fileList[i];
                $wire.upload('files', file, (uploadedFilename) => {
                    this.uploading = true;
                }, (error) => {
                    console.error(error);
                    this.uploading = false;
                }, (event) => {
                    this.progress = event.detail.progress;
                });
            }
        },
        removeFile(index) {
            $wire.removeFile(index);
        },
        getFileIcon(type) {
            if (type.startsWith('image/')) {
                return 'image';
            } else if (type.includes('pdf')) {
                return 'pdf';
            } else if (type.includes('word') || type.includes('doc')) {
                return 'doc';
            } else if (type.includes('excel') || type.includes('sheet')) {
                return 'sheet';
            } else {
                return 'file';
            }
        }
    }"
    class="w-full"
>
    <div class="mb-2">
        <label class="block text-sm font-medium text-gray-700">
            {{ $label ?? 'File Upload' }}
        </label>
        
        <!-- Drag and drop area -->
        @if($dragDrop)
        <div
            x-on:dragover.prevent="dragOver = true"
            x-on:dragleave.prevent="dragOver = false"
            x-on:drop.prevent="handleFileDrop($event)"
            x-bind:class="{'bg-blue-50 border-blue-300': dragOver, 'bg-gray-50 border-gray-300': !dragOver}"
            class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-md transition-colors duration-200"
        >
            <div class="space-y-1 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <div class="flex text-sm text-gray-600">
                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                        <span>Upload a file</span>
                        <input 
                            id="file-upload" 
                            name="file-upload" 
                            type="file" 
                            class="sr-only" 
                            x-on:change="handleFileInput($event)"
                            {{ $maxFiles !== null && $maxFiles > 1 ? 'multiple' : '' }}
                            accept="{{ $accept }}"
                        >
                    </label>
                    <p class="pl-1">or drag and drop</p>
                </div>
                <p class="text-xs text-gray-500">
                    {{ $maxFiles !== null ? "Up to $maxFiles files, " : '' }}{{ $maxFileSize }}MB max
                </p>
            </div>
        </div>
        @else
        <div class="mt-1">
            <input 
                type="file" 
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                x-on:change="handleFileInput($event)"
                {{ $maxFiles !== null && $maxFiles > 1 ? 'multiple' : '' }}
                accept="{{ $accept }}"
            >
        </div>
        @endif
        
        <!-- Progress bar -->
        <div x-show="uploading" class="mt-2">
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-indigo-600 h-2.5 rounded-full" x-bind:style="`width: ${progress}%`"></div>
            </div>
            <p class="text-xs text-gray-500 mt-1">Uploading... <span x-text="`${progress}%`"></span></p>
        </div>
        
        <!-- File previews -->
        @if($showPreview)
        <div class="mt-4 space-y-2" x-show="files.length > 0">
            <template x-for="(file, index) in files" :key="index">
                <div class="flex items-center justify-between p-2 bg-gray-50 rounded-md">
                    <div class="flex items-center space-x-2">
                        <!-- File icon based on type -->
                        <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-gray-100 rounded-md">
                            <template x-if="file.temporaryUrl && file.type && file.type.startsWith('image/')">
                                <img :src="file.temporaryUrl" class="w-8 h-8 object-cover rounded" />
                            </template>
                            <template x-if="!file.temporaryUrl || !file.type || !file.type.startsWith('image/')">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                </svg>
                            </template>
                        </div>
                        
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-gray-900" x-text="file.name || 'File ' + (index + 1)"></span>
                            <span class="text-xs text-gray-500" x-text="$wire.getHumanReadableSize(file.size || 0)"></span>
                        </div>
                    </div>
                    
                    <button 
                        type="button" 
                        class="text-red-500 hover:text-red-700 focus:outline-none"
                        x-on:click="removeFile(index)"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>
        @endif
        
        <!-- Upload button -->
        <div class="mt-4" x-show="files.length > 0">
            <button 
                type="button" 
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                wire:click="upload"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Upload</span>
                <span wire:loading>Processing...</span>
            </button>
        </div>
        
        @error('files.*')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>