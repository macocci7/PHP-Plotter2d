<?php

namespace Macocci7\PhpPlotter2d\Enums;

use Macocci7\PhpPlotter2d\Traits\EnumTrait;

enum Position: string
{
    use EnumTrait;

    case Top = 'top';
    case Middle = 'middle';
    case Bottom = 'Bottom';
    case Left = 'left';
    case Center = 'center';
    case Right = 'right';
    case Upper = 'upper';
    case Lower = 'lower';
}
