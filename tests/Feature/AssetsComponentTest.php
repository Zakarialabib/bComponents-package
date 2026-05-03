<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class AssetsComponentTest extends TestCase
{
    public function test_assets_component_outputs_css_and_js_links(): void
    {
        $html = Blade::render('<x-b-assets />');

        $this->assertStringContainsString('vendor/bcomponents/css/bcomponents.css', $html);
        $this->assertStringContainsString('vendor/bcomponents/js/bcomponents.js', $html);
        $this->assertStringContainsString('type="module"', $html);
    }
}

