<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests\Feature;

use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Zakarialabib\BComponents\Tests\TestCase;

final class ConfigContractRegressionTest extends TestCase
{
    public function test_runtime_code_does_not_reference_removed_config_keys(): void
    {
        $root = dirname(__DIR__, 2);
        $src = $root . '/src';

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($src));

        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }

            if (!Str::endsWith($file->getFilename(), '.php')) {
                continue;
            }

            $contents = file_get_contents($file->getPathname());
            $this->assertIsString($contents);

            $this->assertStringNotContainsString('default_classes', $contents, $file->getPathname());
            $this->assertStringNotContainsString('css_framework', $contents, $file->getPathname());
        }
    }
}
