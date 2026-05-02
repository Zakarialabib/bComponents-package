<?php

declare(strict_types=1);

namespace Zakarialabib\BComponents\Support\Styles\Button;

final class ButtonVariants
{
    public static function classes(string $variant, string $tone): string
    {
        $toneSolid = match ($tone) {
            default => 'bg-[color:var(--b-color-primary)] text-white',
        };

        return match ($variant) {
            'outline' => 'border border-[color:var(--b-color-border)] bg-transparent text-[color:var(--b-color-text)]',
            'ghost' => 'bg-transparent text-[color:var(--b-color-text)]',
            'link' => 'bg-transparent text-[color:var(--b-color-primary)] underline-offset-4 hover:underline',
            default => $toneSolid,
        };
    }
}

