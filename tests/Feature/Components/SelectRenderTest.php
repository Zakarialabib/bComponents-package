<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class SelectRenderTest extends TestCase
{
    public function test_renders_select_with_options_and_token_classes(): void
    {
        $options = [
            'admin' => 'Admin',
            'user' => 'User',
        ];

        $html = Blade::render('<x-b-select name="role" :options="$options" />', [
            'options' => $options,
        ]);

        $this->assertStringContainsString('<select', $html);
        $this->assertStringContainsString('name="role"', $html);
        $this->assertStringContainsString('Admin', $html);
        $this->assertStringContainsString('appearance-none', $html);
        $this->assertStringContainsString('bg-[color:var(--b-color-surface)]', $html);
    }
}

