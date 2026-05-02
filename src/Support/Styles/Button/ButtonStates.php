<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles\Button;

final class ButtonStates
{
    public static function classes(bool $disabled, bool $loading, bool $fullWidth): string
    {
        return trim(implode(' ', array_filter([
            $disabled ? 'opacity-50 cursor-not-allowed' : '',
            $loading ? 'opacity-75 cursor-wait' : '',
            $fullWidth ? 'w-full' : '',
        ])));
    }
}

