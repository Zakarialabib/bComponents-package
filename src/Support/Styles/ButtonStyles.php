<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles;

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

        $base = 'inline-flex items-center justify-center font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-150 select-none';
        $radius = 'rounded-[var(--b-radius-md)]';
        $shadow = 'shadow-[var(--b-shadow-sm)]';

        $sizes = [
            'sm' => 'px-3 py-2 text-sm',
            'md' => 'px-4 py-2 text-sm',
            'lg' => 'px-5 py-2.5 text-base',
        ];

        $toneSolid = match ($tone) {
            default => 'bg-[color:var(--b-color-primary)] text-white',
        };

        $variantClasses = match ($variant) {
            'outline' => 'border border-[color:var(--b-color-border)] bg-transparent text-[color:var(--b-color-text)]',
            'ghost' => 'bg-transparent text-[color:var(--b-color-text)]',
            'link' => 'bg-transparent text-[color:var(--b-color-primary)] underline-offset-4 hover:underline',
            default => $toneSolid,
        };

        $state = trim(implode(' ', array_filter([
            $disabled ? 'opacity-50 cursor-not-allowed' : '',
            $loading ? 'opacity-75 cursor-wait' : '',
            $fullWidth ? 'w-full' : '',
        ])));

        return trim($base . ' ' . $radius . ' ' . $shadow . ' ' . ($sizes[$size] ?? $sizes['md']) . ' ' . $variantClasses . ' ' . $state);
    }
}

