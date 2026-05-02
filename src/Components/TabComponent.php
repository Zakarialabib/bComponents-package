<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Components;

final class TabComponent extends BaseComponent
{
    public function __construct(
        string $name = '',
        string $title = '',
        bool $disabled = false,
    ) {
        parent::__construct();

        $this->name = $name;
        $this->title = $title;
        $this->disabled = $disabled;
    }

    public string $name = '';
    public string $title = '';
    public bool $disabled = false;

    protected ?string $view = 'bcomponents::components.tab';

    protected array $props = [
        'name' => '',
        'title' => '',
        'disabled' => false,
    ];
}
