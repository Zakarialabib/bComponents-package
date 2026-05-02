<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

final class SelectDropdownComponent extends BaseComponent
{
    public function __construct(
        string $name = '',
        ?string $placeholder = null,
        array $options = [],
        mixed $value = null,
        bool $required = false,
        bool $disabled = false,
    ) {
        parent::__construct();

        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->options = $options;
        $this->value = $value;
        $this->required = $required;
        $this->disabled = $disabled;
    }

    public string $name = '';
    public ?string $placeholder = null;
    public array $options = [];
    public $value = null;
    public bool $required = false;
    public bool $disabled = false;

    protected ?string $view = 'bcomponents::components.select-dropdown';

    protected array $props = [
        'name' => '',
        'placeholder' => null,
        'options' => [],
        'value' => null,
        'required' => false,
        'disabled' => false,
    ];

    protected function viewData(): array
    {
        $selectedLabel = null;
        foreach ($this->options as $option) {
            if (!is_array($option)) {
                continue;
            }

            if (($option['value'] ?? null) === $this->value) {
                $selectedLabel = $option['label'] ?? null;
                break;
            }
        }

        return array_merge(parent::viewData(), [
            'selectedLabel' => $selectedLabel,
        ]);
    }
}
