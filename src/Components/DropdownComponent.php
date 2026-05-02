<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

final class DropdownComponent extends BaseComponent
{
    public function __construct(
        string $align = 'left',
        string $width = 'md',
        bool $open = false,
    ) {
        parent::__construct();

        $this->align = $align;
        $this->width = $width;
        $this->open = $open;
    }

    public string $align = 'left';
    public string $width = 'md';
    public bool $open = false;

    protected ?string $view = 'bcomponents::components.dropdown';

    protected array $props = [
        'align' => 'left',
        'width' => 'md',
        'open' => false,
    ];

    protected function viewData(): array
    {
        $widthClass = match ($this->width) {
            'sm' => 'w-40',
            'lg' => 'w-72',
            default => 'w-56',
        };

        $alignClass = $this->align === 'right' ? 'right-0' : 'left-0';

        return array_merge(parent::viewData(), [
            'widthClass' => $widthClass,
            'alignClass' => $alignClass,
        ]);
    }
}
