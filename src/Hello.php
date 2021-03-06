<?php

/**
 * @desc Hello
 */

declare(strict_types=1);

namespace Tinywan\Template;

class Hello
{
    public function isBoole(): bool
    {
        return true;
    }

    public function isEmpty()
    {
        return '';
    }

    public function isYearString(): string
    {
        return 'isYear';
    }

    public function isStrictString(string $string): string
    {
        return 'isStrictString';
    }

    public function isMultipleInt(int ...$numbers): int
    {
        $acc = 0;
        foreach ($numbers as $n) {
            $acc += $n;
        }

        return $acc;
    }

    public function isArray(): array
    {
        return ['isArray'];
    }

    public function isArrayMerge(array ...$arrays): array
    {
        return array_merge($arrays);
    }

    public function csFixer(): array
    {
        $a = 123;
        $bb = 123;

        if ($a = $bb) {
            echo 1;
        }

        unset($a, $bb);
        $aa = [1, 22, 333, 44];

        return [];
    }
}
