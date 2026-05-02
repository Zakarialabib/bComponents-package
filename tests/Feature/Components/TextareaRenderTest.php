<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature\Components;

use Illuminate\Support\Facades\Blade;
use Zakarialabib\BComponents\Tests\TestCase;

final class TextareaRenderTest extends TestCase
{
    public function test_renders_textarea_with_name_and_token_classes(): void
    {
        $html = Blade::render('<x-b-textarea name="bio" resize="none">Text</x-b-textarea>');

        $this->assertStringContainsString('<textarea', $html);
        $this->assertStringContainsString('name="bio"', $html);
        $this->assertStringContainsString('resize-none', $html);
        $this->assertStringContainsString('bg-[color:var(--b-color-surface)]', $html);
    }
}

