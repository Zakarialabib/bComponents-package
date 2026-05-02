<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Metadata;

final class ComponentMetadataRepository
{
    public function all(): array
    {
        return [
            'button' => [
                'name' => 'Button',
                'category' => 'primitives',
                'props' => [
                    'variant' => ['type' => 'string', 'default' => 'solid'],
                    'size' => ['type' => 'string', 'default' => 'md'],
                    'tone' => ['type' => 'string', 'default' => 'primary'],
                    'disabled' => ['type' => 'bool', 'default' => false],
                    'loading' => ['type' => 'bool', 'default' => false],
                    'icon' => ['type' => 'string|null', 'default' => null],
                ],
                'slots' => ['default'],
                'a11y' => ['Use native button semantics; use aria-disabled when disabled on anchors.'],
                'compat' => ['Blade', 'Livewire 3/4', 'Alpine optional'],
            ],
            'input' => [
                'name' => 'Input',
                'category' => 'primitives',
                'props' => [
                    'type' => ['type' => 'string', 'default' => 'text'],
                    'name' => ['type' => 'string', 'default' => ''],
                    'disabled' => ['type' => 'bool', 'default' => false],
                    'invalid' => ['type' => 'bool', 'default' => false],
                ],
                'slots' => [],
                'a11y' => ['Requires label association in consuming markup (for/id).'],
                'compat' => ['Blade', 'Livewire 3/4'],
            ],
        ];
    }
}

