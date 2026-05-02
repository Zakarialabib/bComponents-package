<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Tests;

use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [\Zakarialabib\BComponents\BComponentsServiceProvider::class];
    }
}

