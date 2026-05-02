<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class ModalRenderTest extends TestCase
{
    public function test_renders_modal_with_open_close_hooks(): void
    {
        $html = Blade::render('<x-b-modal :name="\'settings\'" :show="true">Body</x-b-modal>');

        $this->assertStringContainsString('x-on:open-modal.window', $html);
        $this->assertStringContainsString('x-on:close-modal.window', $html);
        $this->assertStringContainsString('Body', $html);
    }

    public function test_static_modal_disables_backdrop_close(): void
    {
        $html = Blade::render('<x-b-modal :name="\'settings\'" :show="true" :static="true">Body</x-b-modal>');

        $this->assertStringContainsString('x-on:click=""', $html);
    }
}
