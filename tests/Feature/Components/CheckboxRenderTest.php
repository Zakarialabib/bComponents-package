<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class CheckboxRenderTest extends TestCase
{
    public function test_renders_checkbox_and_merges_token_classes(): void
    {
        $html = Blade::render('<x-b-checkbox name="agree" label="Agree" class="custom" />');

        $this->assertStringContainsString('type="checkbox"', $html);
        $this->assertStringContainsString('name="agree"', $html);
        $this->assertStringContainsString('Agree', $html);
        $this->assertStringContainsString('border-[color:var(--b-color-border)]', $html);
        $this->assertStringContainsString('custom', $html);
    }
}

