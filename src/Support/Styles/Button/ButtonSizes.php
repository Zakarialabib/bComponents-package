<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles\Button;

final class ButtonSizes
{
    public static function classes(string $size): string
    {
        return match ($size) {
            'sm' => 'px-3 py-2 text-sm',
            'lg' => 'px-5 py-2.5 text-base',
            default => 'px-4 py-2 text-sm',
        };
    }
}

