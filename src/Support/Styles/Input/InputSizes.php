<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles\Input;

final class InputSizes
{
    public static function classes(string $size): string
    {
        return match ($size) {
            'sm' => 'px-3 py-2 text-sm',
            'lg' => 'px-4 py-3 text-base',
            default => 'px-3.5 py-2.5 text-sm',
        };
    }
}

