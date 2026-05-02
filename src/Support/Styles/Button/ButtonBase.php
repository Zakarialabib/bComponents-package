<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles\Button;

final class ButtonBase
{
    public static function classes(): string
    {
        return 'inline-flex items-center justify-center font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-150 select-none rounded-[var(--b-radius-md)] shadow-[var(--b-shadow-sm)]';
    }
}

