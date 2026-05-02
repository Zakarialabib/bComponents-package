<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;

class FormGroupComponent extends BaseComponent
{
    /**
     * The form group name.
     *
     * @var string
     */
    public string $name;

    /**
     * The form group label.
     *
     * @var string|null
     */
    public ?string $label;

    /**
     * The form group help text.
     *
     * @var string|null
     */
    public ?string $helpText;

    /**
     * Whether to show the label.
     *
     * @var bool
     */
    public bool $showLabel;

    /**
     * Whether to show the error.
     *
     * @var bool
     */
    public bool $showError;

    /**
     * Whether the field is required.
     *
     * @var bool
     */
    public bool $required;

    /**
     * Whether to inline the label and input.
     *
     * @var bool
     */
    public bool $inline;

    /**
     * The component's view name.
     *
     * @var string|null
     */
    protected ?string $view = 'bcomponents::components.form-group';

    /**
     * The component's default properties.
     *
     * @var array
     */
    protected array $props = [
        'name' => '',
        'label' => null,
        'helpText' => null,
        'showLabel' => true,
        'showError' => true,
        'required' => false,
        'inline' => false,
    ];

    /**
     * The validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'name' => 'required|string',
        'showLabel' => 'boolean',
        'showError' => 'boolean',
        'required' => 'boolean',
        'inline' => 'boolean',
    ];

    /**
     * The component's base classes.
     *
     * @var string
     */
    protected string $baseClasses = 'mb-4';

    /**
     * Get the view data.
     *
     * @return array
     */
    protected function viewData(): array
    {
        return array_merge(parent::viewData(), [
            'name' => $this->name,
            'label' => $this->label ?? $this->generateLabel(),
            'helpText' => $this->helpText,
            'showLabel' => $this->showLabel,
            'showError' => $this->showError,
            'required' => $this->required,
            'inline' => $this->inline,
            'hasError' => $this->hasError(),
            'error' => $this->getError(),
            'labelClasses' => $this->getLabelClasses(),
            'inputWrapperClasses' => $this->getInputWrapperClasses(),
        ]);
    }

    /**
     * Generate a label from the name.
     *
     * @return string
     */
    protected function generateLabel(): string
    {
        return Str::title(str_replace(['_', '-', '.'], ' ', $this->name));
    }

    /**
     * Determine if the field has an error.
     *
     * @return bool
     */
    protected function hasError(): bool
    {
        if (!$this->showError) {
            return false;
        }

        $errors = session('errors');

        if (!$errors instanceof ViewErrorBag) {
            return false;
        }

        return $errors->has($this->name);
    }

    /**
     * Get the error message.
     *
     * @return string|null
     */
    protected function getError(): ?string
    {
        if (!$this->hasError()) {
            return null;
        }

        $errors = session('errors');

        return $errors->first($this->name);
    }

    /**
     * Get the label classes.
     *
     * @return string
     */
    protected function getLabelClasses(): string
    {
        $baseClasses = 'block text-sm font-medium text-[color:var(--b-color-text)]';
        
        if ($this->inline) {
            return $baseClasses . ' sm:mt-px sm:pt-2';
        }
        
        return $baseClasses . ' mb-1';
    }

    /**
     * Get the input wrapper classes.
     *
     * @return string
     */
    protected function getInputWrapperClasses(): string
    {
        if ($this->inline) {
            return 'sm:mt-0 sm:col-span-2';
        }
        
        return '';
    }
} 
