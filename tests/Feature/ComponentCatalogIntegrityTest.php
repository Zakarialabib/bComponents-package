<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature;

use Zakarialabib\BComponents\Support\ComponentRegistry;
use Zakarialabib\BComponents\Tests\TestCase;

final class ComponentCatalogIntegrityTest extends TestCase
{
    public function test_each_registry_component_has_a_canonical_view_template(): void
    {
        $root = dirname(__DIR__, 2);
        $views = $root . '/resources/views/components';

        $registry = new ComponentRegistry();
        foreach (array_keys($registry->aliases()) as $alias) {
            if (str_starts_with($alias, 'table.')) {
                $leaf = substr($alias, strlen('table.'));
                $path = $views . '/table/' . $leaf . '.blade.php';
            } elseif ($alias === 'table') {
                $path = $views . '/table/table.blade.php';
            } else {
                $path = $views . '/' . $alias . '.blade.php';
            }

            $this->assertFileExists($path, $alias);
        }
    }

    public function test_each_public_component_has_a_catalog_page(): void
    {
        $root = dirname(__DIR__, 2);
        $docs = $root . '/docs/components';

        $registry = new ComponentRegistry();
        foreach (array_keys($registry->aliases()) as $alias) {
            $path = $docs . '/blade/' . str_replace('.', '/', $alias) . '.md';
            $this->assertFileExists($path, $alias);
        }

        foreach ([
            'autocomplete',
            'date-picker',
            'dropdown',
            'file-upload',
            'modal',
            'multi-select',
            'rich-text-editor',
            'table',
            'tabs',
        ] as $alias) {
            $path = $docs . '/livewire/' . $alias . '.md';
            $this->assertFileExists($path, $alias);
        }

        $this->assertFileExists($docs . '/index.md');
    }
}

