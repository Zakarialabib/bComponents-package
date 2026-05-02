<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class ToggleRenderTest extends TestCase
{
    public function test_renders_toggle_with_switch_role_and_alpine(): void
    {
        $html = Blade::render('<x-b-toggle name="notifications" label="Notifications" />');

        $this->assertStringContainsString('role="switch"', $html);
        $this->assertStringContainsString('x-data', $html);
        $this->assertStringContainsString(':class="checked ? \'bg-[color:var(--b-color-primary)]\'', $html);
    }
}

