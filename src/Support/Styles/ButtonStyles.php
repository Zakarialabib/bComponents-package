<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles;

use Zakarialabib\BComponents\Support\Styles\Button\ButtonBase;
use Zakarialabib\BComponents\Support\Styles\Button\ButtonSizes;
use Zakarialabib\BComponents\Support\Styles\Button\ButtonStates;
use Zakarialabib\BComponents\Support\Styles\Button\ButtonVariants;

final class ButtonStyles
{
    public static function classes(array $opts): string
    {
        $variant = (string) ($opts['variant'] ?? 'solid');
        $size = (string) ($opts['size'] ?? 'md');
        $tone = (string) ($opts['tone'] ?? 'primary');
        $disabled = (bool) ($opts['disabled'] ?? false);
        $loading = (bool) ($opts['loading'] ?? false);
        $fullWidth = (bool) ($opts['full_width'] ?? false);

        return trim(implode(' ', array_filter([
            ButtonBase::classes(),
            ButtonSizes::classes($size),
            ButtonVariants::classes($variant, $tone),
            ButtonStates::classes($disabled, $loading, $fullWidth),
        ])));
    }
}
