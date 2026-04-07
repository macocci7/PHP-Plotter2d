<?php

namespace Macocci7\PhpPlotter2d\Enums;

use Intervention\Image\Alignment;
use Macocci7\PhpPlotter2d\Traits\EnumTrait;

enum Align: string
{
    use EnumTrait;

    case Left = 'left';
    case Center = 'center';
    case Right = 'right';
    case Top = 'top';
    case Middle = 'middle';
    case Bottom = 'bottom';

    /**
     * returns a fully qualified class name of the image driver
     */
    public static function parse(string|null $align): Alignment|null
    {
        return match ($align) {
            self::Left->value => Alignment::LEFT,
            self::Center->value => Alignment::CENTER,
            self::Right->value => Alignment::RIGHT,
            self::Top->value => Alignment::TOP,
            self::Middle->value => Alignment::CENTER,
            self::Bottom->value => Alignment::BOTTOM,
            default => null,
        };
    }
}
