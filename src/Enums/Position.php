<?php

namespace Macocci7\PhpPlotter2d\Enums;

use Macocci7\PhpPlotter2d\Traits\EnumTrait;

enum Position: string
{
    use EnumTrait;

    case Top = 'top';
    case Middle = 'middle';
    case Bottom = 'bottom';
    case Left = 'left';
    case Center = 'center';
    case Right = 'right';
    case Upper = 'upper';
    case Lower = 'lower';

    /**
     * returns a composit position as text
     *
     * @param   string  $align
     * @param   string  $valign
     * @return  string|null
     */
    public static function composit(string $align, string $valign)
    {
        $h = self::get($align);
        $v = self::get($valign);
        if (is_null($h) || is_null($v)) {
            return null;
        }
        return match ([$h, $v]) {
            [self::Left, self::Top] => 'top-left',
            [self::Center, self::Top] => 'top',
            [self::Right, self::Top] => 'top-right',
            [self::Left, self::Middle] => 'left',
            [self::Center, self::Middle] => 'center',
            [self::Right, self::Middle] => 'right',
            [self::Left, self::Bottom] => 'bottom-left',
            [self::Center, self::Bottom] => 'bottom',
            [self::Right, self::Bottom] => 'bottom-right',
            default => null,
        };
    }
}
