<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles;

final class InputStyles
{
    public static function classes(array $opts): string
    {
        $size = (string) ($opts['size'] ?? 'md');
        $invalid = (bool) ($opts['invalid'] ?? false);
        $disabled = (bool) ($opts['disabled'] ?? false);

        $base = 'block w-full rounded-[var(--b-radius-md)] border bg-[color:var(--b-color-surface)] text-[color:var(--b-color-text)] shadow-[var(--b-shadow-sm)] focus:outline-none focus:ring-2 focus:ring-offset-2';
        $border = $invalid ? 'border-red-500 focus:ring-red-500' : 'border-[color:var(--b-color-border)] focus:ring-[color:var(--b-color-primary)]';

        $sizes = [
            'sm' => 'px-3 py-2 text-sm',
            'md' => 'px-3.5 py-2.5 text-sm',
            'lg' => 'px-4 py-3 text-base',
        ];

        $state = $disabled ? 'opacity-50 cursor-not-allowed' : '';

        return trim($base . ' ' . $border . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . $state);
    }
}

