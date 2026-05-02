<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles\Input;

final class InputBase
{
    public static function classes(): string
    {
        return 'block w-full rounded-[var(--b-radius-md)] border bg-[color:var(--b-color-surface)] text-[color:var(--b-color-text)] shadow-[var(--b-shadow-sm)] focus:outline-none focus:ring-2 focus:ring-offset-2';
    }
}

