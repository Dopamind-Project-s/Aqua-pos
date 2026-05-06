<?php

namespace App\Support;

class LineList
{
    public static function fromTextarea(mixed $value): ?array
    {
        if (is_array($value)) {
            $value = implode(PHP_EOL, $value);
        }

        $items = collect(preg_split('/\R/u', (string) $value))
            ->map(fn (string $item): string => trim($item))
            ->filter()
            ->values()
            ->all();

        return $items === [] ? null : $items;
    }

    public static function toTextarea(mixed $items): string
    {
        if (is_string($items)) {
            return $items;
        }

        return implode(PHP_EOL, $items ?? []);
    }
}
