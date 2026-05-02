<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles;

use Zakarialabib\BComponents\Support\Styles\Input\InputBase;
use Zakarialabib\BComponents\Support\Styles\Input\InputSizes;
use Zakarialabib\BComponents\Support\Styles\Input\InputStates;

final class InputStyles
{
    public static function classes(array $opts): string
    {
        $size = (string) ($opts['size'] ?? 'md');
        $invalid = (bool) ($opts['invalid'] ?? false);
        $disabled = (bool) ($opts['disabled'] ?? false);

        return trim(implode(' ', array_filter([
            InputBase::classes(),
            InputSizes::classes($size),
            InputStates::classes($invalid, $disabled),
        ])));
    }
}
