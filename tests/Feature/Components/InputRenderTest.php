<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class InputRenderTest extends TestCase
{
    public function test_renders_input_with_name_and_classes(): void
    {
        $html = Blade::render('<x-b-input name="email" class="custom" />');

        $this->assertStringContainsString('name="email"', $html);
        $this->assertStringContainsString('custom', $html);
        $this->assertStringContainsString('bg-[color:var(--b-color-surface)]', $html);
    }
}

