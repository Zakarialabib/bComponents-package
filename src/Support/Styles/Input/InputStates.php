<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles\Input;

final class InputStates
{
    public static function classes(bool $invalid, bool $disabled): string
    {
        $border = $invalid
            ? 'border-red-500 focus:ring-red-500'
            : 'border-[color:var(--b-color-border)] focus:ring-[color:var(--b-color-primary)]';

        $state = $disabled ? 'opacity-50 cursor-not-allowed' : '';

        return trim($border . ' ' . $state);
    }
}

