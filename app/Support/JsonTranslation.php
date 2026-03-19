<?php

namespace App\Support;

class JsonTranslation
{
    public static function decode(?string $value): ?array
    {
        if (! is_string($value) || trim($value) === '') {
            return null;
        }

        $decoded = json_decode($value, true);

        if (! is_array($decoded)) {
            return null;
        }

        if (! array_key_exists('ar', $decoded) && ! array_key_exists('en', $decoded)) {
            return null;
        }

        return [
            'ar' => isset($decoded['ar']) ? (string) $decoded['ar'] : null,
            'en' => isset($decoded['en']) ? (string) $decoded['en'] : null,
        ];
    }

    public static function encode(?string $ar, ?string $en, ?string $fallback = null): ?string
    {
        $ar = self::normalize($ar);
        $en = self::normalize($en);
        $fallback = self::normalize($fallback);

        $arValue = $ar ?? $fallback;
        $enValue = $en ?? $fallback;

        if ($arValue === null && $enValue === null) {
            return null;
        }

        return json_encode([
            'ar' => $arValue,
            'en' => $enValue,
        ], JSON_UNESCAPED_UNICODE);
    }

    public static function pick(?string $jsonValue, ?string $arFallback, ?string $enFallback, string $locale): ?string
    {
        $decoded = self::decode($jsonValue);

        if (is_array($decoded)) {
            if ($locale === 'ar') {
                return $decoded['ar'] ?: $decoded['en'] ?: $arFallback ?: $enFallback;
            }

            return $decoded['en'] ?: $decoded['ar'] ?: $enFallback ?: $arFallback;
        }

        if ($locale === 'ar') {
            return $arFallback ?: $enFallback ?: $jsonValue;
        }

        return $enFallback ?: $arFallback ?: $jsonValue;
    }

    public static function extractLocale(?string $value, string $locale): ?string
    {
        $decoded = self::decode($value);
        if (! $decoded) {
            return $value;
        }

        if ($locale === 'ar') {
            return $decoded['ar'] ?: $decoded['en'];
        }

        return $decoded['en'] ?: $decoded['ar'];
    }

    private static function normalize(?string $value): ?string
    {
        $value = is_string($value) ? trim($value) : null;

        return $value === '' ? null : $value;
    }
}
