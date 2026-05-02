<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

final class TabsComponent extends BaseComponent
{
    public function __construct(?string $default = null)
    {
        parent::__construct();

        $this->default = $default;
    }

    public ?string $default = null;

    protected ?string $view = 'bcomponents::components.tabs';

    protected array $props = [
        'default' => null,
    ];
}
