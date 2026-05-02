<?php

namespace Zakarialabib\BComponents\Livewire;

use Illuminate\Support\Facades\View;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class FileUploadComponent extends BaseComponent
{
    use WithFileUploads;

    /**
     * The uploaded files.
     *
     * @var array
     */
    public $files = [];

    /**
     * The accepted file types.
     *
     * @var string
     */
    public $accept = '*';

    /**
     * The maximum file size in MB.
     *
     * @var int
     */
    public $maxFileSize = 5;

    /**
     * The maximum number of files that can be uploaded.
     *
     * @var int|null
     */
    public $maxFiles = null;

    /**
     * Whether to show the file preview.
     *
     * @var bool
     */
    public $showPreview = true;

    /**
     * The upload directory.
     *
     * @var string
     */
    public $uploadDirectory = 'uploads';

    /**
     * Whether to enable drag and drop.
     *
     * @var bool
     */
    public $dragDrop = true;

    /**
     * The validation rules.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * The listeners for the component.
     *
     * @var array
     */
    protected $listeners = [
        'fileRemoved' => 'removeFile',
        'refresh' => '$refresh',
    ];

    /**
     * Mount the component.
     *
     * @param string $accept
     * @param int $maxFileSize
     * @param int|null $maxFiles
     * @param bool $showPreview
     * @param string $uploadDirectory
     * @param bool $dragDrop
     * @return void
     */
    public function mount(
        $accept = '*',
        $maxFileSize = 5,
        $maxFiles = null,
        $showPreview = true,
        $uploadDirectory = 'uploads',
        $dragDrop = true
    ) {
        $this->accept = $accept;
        $this->maxFileSize = $maxFileSize;
        $this->maxFiles = $maxFiles;
        $this->showPreview = $showPreview;
        $this->uploadDirectory = $uploadDirectory;
        $this->dragDrop = $dragDrop;

        // Set up validation rules
        $this->rules = [
            'files.*' => [
                'file',
                'max:' . ($this->maxFileSize * 1024),
            ],
        ];

        // Add mime type validation if specific types are provided
        if ($this->accept !== '*') {
            $mimeTypes = $this->parseMimeTypes($this->accept);
            if (!empty($mimeTypes)) {
                $this->rules['files.*'][] = 'mimetypes:' . implode(',', $mimeTypes);
            }
        }
    }

    /**
     * Parse the accept attribute to get mime types.
     *
     * @param string $accept
     * @return array
     */
    protected function parseMimeTypes($accept)
    {
        $mimeTypes = [];
        $types = explode(',', $accept);

        foreach ($types as $type) {
            $type = trim($type);
            if (strpos($type, 'image/') === 0) {
                $mimeTypes[] = $type;
            } elseif ($type === 'image/*') {
                $mimeTypes[] = 'image/jpeg';
                $mimeTypes[] = 'image/png';
                $mimeTypes[] = 'image/gif';
                $mimeTypes[] = 'image/webp';
            } elseif ($type === '.pdf') {
                $mimeTypes[] = 'application/pdf';
            } elseif ($type === '.doc' || $type === '.docx') {
                $mimeTypes[] = 'application/msword';
                $mimeTypes[] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
            }
            // Add more mime type mappings as needed
        }

        return $mimeTypes;
    }

    /**
     * Upload the files.
     *
     * @return void
     */
    public function upload()
    {
        $this->validate();

        $uploadedFiles = [];

        foreach ($this->files as $file) {
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs($this->uploadDirectory, $filename, 'public');
            
            $uploadedFiles[] = [
                'name' => $filename,
                'path' => $path,
                'url' => Storage::url($path),
                'size' => $file->getSize(),
                'type' => $file->getMimeType(),
            ];
        }

        $this->reset('files');
        $this->emit('filesUploaded', $uploadedFiles);
    }

    /**
     * Remove a file from the upload list.
     *
     * @param int $index
     * @return void
     */
    public function removeFile($index)
    {
        if (isset($this->files[$index])) {
            unset($this->files[$index]);
            $this->files = array_values($this->files);
        }
    }

    /**
     * Get the file size in a human-readable format.
     *
     * @param int $size
     * @return string
     */
    public function getHumanReadableSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        return round($size, 2) . ' ' . $units[$i];
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return View::make('bcomponents::livewire.file-upload');
    }
}