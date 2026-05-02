<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class RadioRenderTest extends TestCase
{
    public function test_renders_radio_and_merges_token_classes(): void
    {
        $html = Blade::render('<x-b-radio name="role" value="admin" label="Admin" class="custom" />');

        $this->assertStringContainsString('type="radio"', $html);
        $this->assertStringContainsString('name="role"', $html);
        $this->assertStringContainsString('Admin', $html);
        $this->assertStringContainsString('border-[color:var(--b-color-border)]', $html);
        $this->assertStringContainsString('custom', $html);
    }
}

