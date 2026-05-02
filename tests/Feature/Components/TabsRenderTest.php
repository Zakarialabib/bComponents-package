<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class TabsRenderTest extends TestCase
{
    public function test_renders_tabs_and_tab_panels(): void
    {
        $html = Blade::render(<<<'BLADE'
<x-b-tabs default="general">
    <x-b-tab name="general" title="General">General Content</x-b-tab>
    <x-b-tab name="security" title="Security">Security Content</x-b-tab>
</x-b-tabs>
BLADE);

        $this->assertStringContainsString('x-data', $html);
        $this->assertStringContainsString('General', $html);
        $this->assertStringContainsString('Security', $html);
        $this->assertStringContainsString('x-show="active === \'general\'"', $html);
    }
}

