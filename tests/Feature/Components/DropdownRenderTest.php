<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class DropdownRenderTest extends TestCase
{
    public function test_renders_dropdown_with_slots_and_alpine(): void
    {
        $html = Blade::render(<<<'BLADE'
<x-b-dropdown>
    <x-slot:trigger><button type="button">Open</button></x-slot:trigger>
    <x-slot:content><a href="#">Item</a></x-slot:content>
</x-b-dropdown>
BLADE);

        $this->assertStringContainsString('Open', $html);
        $this->assertStringContainsString('Item', $html);
        $this->assertStringContainsString('x-data', $html);
        $this->assertStringContainsString('border-[color:var(--b-color-border)]', $html);
    }
}

