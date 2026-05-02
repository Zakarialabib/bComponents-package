<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class CardRenderTest extends TestCase
{
    public function test_hides_header_when_no_title_or_subtitle(): void
    {
        $html = Blade::render('<x-b-card>Body</x-b-card>');

        $this->assertStringContainsString('Body', $html);
        $this->assertStringNotContainsString('<h3', $html);
    }

    public function test_renders_header_when_title_present(): void
    {
        $html = Blade::render('<x-b-card title="Title">Body</x-b-card>');

        $this->assertStringContainsString('Title', $html);
    }
}

