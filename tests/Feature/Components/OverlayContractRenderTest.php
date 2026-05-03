<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class OverlayContractRenderTest extends TestCase
{
    public function test_modal_and_drawer_use_shared_overlay_contract(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-b-modal name="m1" />
            <x-b-drawer name="d1" />
        BLADE);

        $this->assertStringContainsString('x-data="bOverlay', $html);
        $this->assertStringContainsString('open-modal', $html);
        $this->assertStringContainsString('open-drawer', $html);
        $this->assertStringContainsString('keydown.escape', $html);
    }

    public function test_dropdown_has_aria_and_escape_close(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-b-dropdown>
                <x-slot:trigger>Open</x-slot:trigger>
                <x-slot:content>Content</x-slot:content>
            </x-b-dropdown>
        BLADE);

        $this->assertStringContainsString('x-data="bDropdown', $html);
        $this->assertStringContainsString('aria-haspopup="menu"', $html);
        $this->assertStringContainsString('role="menu"', $html);
        $this->assertStringContainsString('keydown.escape', $html);
    }

    public function test_tabs_have_roles_and_keyboard_handlers(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-b-tabs default="t1">
                <x-b-tab name="t1" title="One">One body</x-b-tab>
                <x-b-tab name="t2" title="Two">Two body</x-b-tab>
            </x-b-tabs>
        BLADE);

        $this->assertStringContainsString('x-data="bTabs', $html);
        $this->assertStringContainsString('role="tab"', $html);
        $this->assertStringContainsString('role="tabpanel"', $html);
        $this->assertStringContainsString('onKeydown', $html);
    }

    public function test_toast_uses_shared_toast_contract(): void
    {
        $html = Blade::render('<x-b-toast title="T" />');

        $this->assertStringContainsString('x-data="bToast', $html);
        $this->assertStringContainsString('keydown.escape', $html);
    }
}

