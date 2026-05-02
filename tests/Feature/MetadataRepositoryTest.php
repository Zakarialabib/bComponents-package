<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature;

use Zakarialabib\BComponents\Support\Metadata\ComponentMetadataRepository;
use Zakarialabib\BComponents\Tests\TestCase;

final class MetadataRepositoryTest extends TestCase
{
    public function test_metadata_repository_exposes_core_components(): void
    {
        $repo = $this->app->make(ComponentMetadataRepository::class);
        $all = $repo->all();

        $this->assertArrayHasKey('button', $all);
        $this->assertArrayHasKey('input', $all);
        $this->assertArrayHasKey('textarea', $all);
        $this->assertArrayHasKey('select', $all);
        $this->assertArrayHasKey('checkbox', $all);
        $this->assertArrayHasKey('radio', $all);
        $this->assertArrayHasKey('toggle', $all);
        $this->assertArrayHasKey('alert', $all);
        $this->assertArrayHasKey('card', $all);
        $this->assertArrayHasKey('modal', $all);
        $this->assertArrayHasKey('dropdown', $all);
        $this->assertArrayHasKey('tabs', $all);
    }
}

