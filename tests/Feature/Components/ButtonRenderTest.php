<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class ButtonRenderTest extends TestCase
{
    public function test_renders_button_and_merges_classes(): void
    {
        $html = Blade::render('<x-b-button class="custom">Save</x-b-button>');

        $this->assertStringContainsString('Save', $html);
        $this->assertStringContainsString('custom', $html);
        $this->assertStringContainsString('bg-[color:var(--b-color-primary)]', $html);
    }
}

