<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class AdditionalComponentsRenderTest extends TestCase
{
    public function test_renders_layout_wrappers(): void
    {
        $html = Blade::render('
            <x-b-container class="c1">
                <x-b-grid :cols="2" class="c2">
                    <x-b-flex class="c3">X</x-b-flex>
                </x-b-grid>
                <x-b-divider />
                <x-b-spacer :size="2" />
            </x-b-container>
        ');

        $this->assertStringContainsString('c1', $html);
        $this->assertStringContainsString('c2', $html);
        $this->assertStringContainsString('c3', $html);
    }

    public function test_renders_navigation_and_overlays(): void
    {
        $html = Blade::render(<<<'BLADE'
            <x-b-breadcrumb :items="[
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Page', 'url' => null],
            ]" />

            <x-b-accordion title="Title">Body</x-b-accordion>

            <x-b-drawer :name="'drawer'">
                Drawer
            </x-b-drawer>
        BLADE);

        $this->assertStringContainsString('Breadcrumb', $html);
        $this->assertStringContainsString('accordion-header', $html);
        $this->assertStringContainsString('open-drawer', $html);
    }

    public function test_renders_feedback_components(): void
    {
        $html = Blade::render('
            <x-b-badge tone="primary">New</x-b-badge>
            <x-b-loading />
            <x-b-toast title="Saved">Ok</x-b-toast>
        ');

        $this->assertStringContainsString('New', $html);
        $this->assertStringContainsString('role="status"', $html);
        $this->assertStringContainsString('Saved', $html);
    }

    public function test_renders_table_family(): void
    {
        $html = Blade::render('
            <x-b-table>
                <x-slot:header>
                    <x-b-table.header>
                        <tr>
                            <th>Col</th>
                        </tr>
                    </x-b-table.header>
                </x-slot:header>

                <x-b-table.body>
                    <x-b-table.row>
                        <x-b-table.cell>Cell</x-b-table.cell>
                    </x-b-table.row>
                </x-b-table.body>
            </x-b-table>
        ');

        $this->assertStringContainsString('overflow-x-auto', $html);
        $this->assertStringContainsString('divide-[color:var(--b-color-border)]', $html);
        $this->assertStringContainsString('Cell', $html);
    }
}
