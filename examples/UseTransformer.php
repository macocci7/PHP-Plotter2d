<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpPlotter2d\Transformer;

$transformer = new Transformer(
    viewport: ['x' => [-1, 4], 'y' => [-2, 3]],
    plotarea: [
        'width' => 400,
        'height' => 400,
    ],
);

$x = -0.5;
$y = 2.8;
$coord = $transformer->getCoord($x, $y);
echo "({$x}, {$y}) -> ({$coord['x']}, {$coord['y']})" . PHP_EOL;
