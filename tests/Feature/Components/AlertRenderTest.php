<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class AlertRenderTest extends TestCase
{
    public function test_renders_alert_with_role_and_alpine_hooks(): void
    {
        $html = Blade::render('<x-b-alert title="Hi">Body</x-b-alert>');

        $this->assertStringContainsString('role="alert"', $html);
        $this->assertStringContainsString('x-data', $html);
        $this->assertStringContainsString('Hi', $html);
        $this->assertStringContainsString('Body', $html);
    }

    public function test_closeable_controls_close_button(): void
    {
        $html = Blade::render('<x-b-alert dismissible closeable="false">Body</x-b-alert>');

        $this->assertStringNotContainsString('sr-only">Dismiss', $html);
    }
}

