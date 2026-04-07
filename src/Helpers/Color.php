<?php

namespace Macocci7\PhpPlotter2d\Helpers;

use Intervention\Image\Color as ImageColor;
use Intervention\Image\Interfaces\ColorInterface;

class Color
{
    public static function parse(string|null $color): ColorInterface
    {
        return $color ? ImageColor::parse($color) : ImageColor::transparent();
    }
}
