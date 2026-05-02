<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class BaseComponentPropHandlingTest extends TestCase
{
    public function test_kebab_case_attributes_map_to_camel_case_props(): void
    {
        $html = Blade::render('<x-b-modal :name="\'m\'" max-width="lg" :show="true">Body</x-b-modal>');

        $this->assertStringContainsString('sm:max-w-lg', $html);
    }

    public function test_constructor_props_are_not_overwritten_by_default_hydration(): void
    {
        $html = Blade::render(<<<'BLADE'
<x-b-dropdown align="right" width="lg">
    <x-slot:trigger><button type="button">Open</button></x-slot:trigger>
    <x-slot:content><a href="#">Item</a></x-slot:content>
</x-b-dropdown>
BLADE);

        $this->assertStringContainsString('right-0', $html);
        $this->assertStringContainsString('w-72', $html);
    }
}

