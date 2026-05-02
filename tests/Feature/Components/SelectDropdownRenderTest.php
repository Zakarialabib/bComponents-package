<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class SelectDropdownRenderTest extends TestCase
{
    public function test_renders_select_dropdown_with_hidden_input(): void
    {
        $options = [
            ['value' => 'admin', 'label' => 'Admin'],
            ['value' => 'user', 'label' => 'User'],
        ];

        $html = Blade::render('<x-b-select-dropdown name="role" :options="$options" value="admin" />', [
            'options' => $options,
        ]);

        $this->assertStringContainsString('name="role"', $html);
        $this->assertStringContainsString('Admin', $html);
        $this->assertStringContainsString('x-data', $html);
    }
}

