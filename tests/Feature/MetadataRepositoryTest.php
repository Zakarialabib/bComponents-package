<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature;

use Zakarialabib\BComponents\Support\ComponentRegistry;
use Zakarialabib\BComponents\Support\Metadata\ComponentMetadataRepository;
use Zakarialabib\BComponents\Tests\TestCase;

final class MetadataRepositoryTest extends TestCase
{
    public function test_metadata_repository_covers_all_public_components(): void
    {
        $repo = $this->app->make(ComponentMetadataRepository::class);
        $all = $repo->all();

        $registry = new ComponentRegistry();
        foreach (array_keys($registry->aliases()) as $alias) {
            $this->assertArrayHasKey($alias, $all);
        }

        foreach ([
            'livewire.autocomplete',
            'livewire.date-picker',
            'livewire.dropdown',
            'livewire.file-upload',
            'livewire.modal',
            'livewire.multi-select',
            'livewire.rich-text-editor',
            'livewire.table',
            'livewire.tabs',
        ] as $key) {
            $this->assertArrayHasKey($key, $all);
        }
    }
}
