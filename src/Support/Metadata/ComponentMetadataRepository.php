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
            'textarea' => [
                'name' => 'Textarea',
                'category' => 'primitives',
                'props' => [
                    'name' => ['type' => 'string', 'default' => ''],
                    'rows' => ['type' => 'int', 'default' => 3],
                    'disabled' => ['type' => 'bool', 'default' => false],
                    'invalid' => ['type' => 'bool', 'default' => false],
                    'resize' => ['type' => 'string|null', 'default' => null],
                ],
                'slots' => ['default'],
                'a11y' => ['Requires label association in consuming markup (for/id).'],
                'compat' => ['Blade', 'Livewire 3/4'],
            ],
            'select' => [
                'name' => 'Select',
                'category' => 'primitives',
                'props' => [
                    'name' => ['type' => 'string', 'default' => ''],
                    'options' => ['type' => 'array', 'default' => []],
                    'multiple' => ['type' => 'bool', 'default' => false],
                    'disabled' => ['type' => 'bool', 'default' => false],
                    'invalid' => ['type' => 'bool', 'default' => false],
                ],
                'slots' => [],
                'a11y' => ['Requires label association in consuming markup (for/id).'],
                'compat' => ['Blade', 'Livewire 3/4'],
            ],
            'checkbox' => [
                'name' => 'Checkbox',
                'category' => 'primitives',
                'props' => [
                    'name' => ['type' => 'string', 'default' => ''],
                    'checked' => ['type' => 'bool', 'default' => false],
                    'disabled' => ['type' => 'bool', 'default' => false],
                    'required' => ['type' => 'bool', 'default' => false],
                    'tone' => ['type' => 'string', 'default' => 'primary'],
                ],
                'slots' => [],
                'a11y' => ['Use a visible label; ensure label for/id is set.'],
                'compat' => ['Blade', 'Livewire 3/4'],
            ],
            'radio' => [
                'name' => 'Radio',
                'category' => 'primitives',
                'props' => [
                    'name' => ['type' => 'string', 'default' => ''],
                    'value' => ['type' => 'mixed', 'default' => ''],
                    'checked' => ['type' => 'bool', 'default' => false],
                    'disabled' => ['type' => 'bool', 'default' => false],
                    'required' => ['type' => 'bool', 'default' => false],
                    'tone' => ['type' => 'string', 'default' => 'primary'],
                ],
                'slots' => [],
                'a11y' => ['Use a visible label; ensure label for/id is set.'],
                'compat' => ['Blade', 'Livewire 3/4'],
            ],
            'toggle' => [
                'name' => 'Toggle',
                'category' => 'primitives',
                'props' => [
                    'name' => ['type' => 'string', 'default' => ''],
                    'checked' => ['type' => 'bool', 'default' => false],
                    'disabled' => ['type' => 'bool', 'default' => false],
                    'required' => ['type' => 'bool', 'default' => false],
                    'tone' => ['type' => 'string', 'default' => 'primary'],
                ],
                'slots' => [],
                'a11y' => ['Uses role="switch"; ensure label text is present.'],
                'compat' => ['Blade', 'Livewire 3/4', 'Alpine required'],
            ],
            'badge' => [
                'name' => 'Badge',
                'category' => 'primitives',
                'props' => [
                    'tone' => ['type' => 'string', 'default' => 'primary'],
                    'size' => ['type' => 'string', 'default' => 'md'],
                ],
                'slots' => ['default'],
                'a11y' => [],
                'compat' => ['Blade'],
            ],
            'alert' => [
                'name' => 'Alert',
                'category' => 'feedback',
                'props' => [
                    'type' => ['type' => 'string', 'default' => 'info'],
                    'dismissible' => ['type' => 'bool', 'default' => false],
                    'title' => ['type' => 'string|null', 'default' => null],
                ],
                'slots' => ['default'],
                'a11y' => ['Uses role="alert"; ensure text is meaningful.'],
                'compat' => ['Blade', 'Alpine required for dismissible'],
            ],
            'card' => [
                'name' => 'Card',
                'category' => 'layout',
                'props' => [
                    'title' => ['type' => 'string|null', 'default' => null],
                    'subtitle' => ['type' => 'string|null', 'default' => null],
                    'showFooter' => ['type' => 'bool', 'default' => false],
                ],
                'slots' => ['default', 'header', 'footer'],
                'a11y' => [],
                'compat' => ['Blade'],
            ],
            'modal' => [
                'name' => 'Modal',
                'category' => 'overlays',
                'props' => [
                    'name' => ['type' => 'string', 'default' => ''],
                    'show' => ['type' => 'bool', 'default' => false],
                    'maxWidth' => ['type' => 'string', 'default' => '2xl'],
                    'static' => ['type' => 'bool', 'default' => false],
                ],
                'slots' => ['default', 'footer'],
                'a11y' => ['Keyboard escape close (unless static).'],
                'compat' => ['Blade', 'Alpine required'],
            ],
            'dropdown' => [
                'name' => 'Dropdown',
                'category' => 'overlays',
                'props' => [
                    'align' => ['type' => 'string', 'default' => 'left'],
                    'width' => ['type' => 'string', 'default' => 'md'],
                ],
                'slots' => ['trigger', 'content'],
                'a11y' => ['Escape closes; click-away closes.'],
                'compat' => ['Blade', 'Alpine required'],
            ],
            'select-dropdown' => [
                'name' => 'Select Dropdown',
                'category' => 'forms',
                'props' => [
                    'name' => ['type' => 'string', 'default' => ''],
                    'options' => ['type' => 'array', 'default' => []],
                    'value' => ['type' => 'mixed|null', 'default' => null],
                ],
                'slots' => [],
                'a11y' => ['Ensure label association in consuming markup.'],
                'compat' => ['Blade', 'Alpine required'],
            ],
            'tabs' => [
                'name' => 'Tabs',
                'category' => 'navigation',
                'props' => [
                    'default' => ['type' => 'string|null', 'default' => null],
                ],
                'slots' => ['default', 'tab'],
                'a11y' => ['Keyboard support is minimal in v1; ensure visible focus styles.'],
                'compat' => ['Blade', 'Alpine required'],
            ],
        ];
    }
}
