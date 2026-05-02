<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles;

final class SurfaceStyles
{
    public static function classes(array $opts): string
    {
        $variant = (string) ($opts['variant'] ?? 'default');

        $base = 'bg-[color:var(--b-color-surface)] text-[color:var(--b-color-text)]';

        return trim($base . ' ' . match ($variant) {
            'bordered' => 'border border-[color:var(--b-color-border)]',
            'elevated' => 'shadow-[var(--b-shadow-sm)]',
            default => '',
        });
    }
}

