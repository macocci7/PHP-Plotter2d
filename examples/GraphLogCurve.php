<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpPlotter2d\Plotter;

// Instantiation
$size = 400;
$viewport = ['x' => [-1, 4], 'y' => [-2, 3]];
$plotarea = [ // full size
    'offset' => [0, 0],
    'width' => $size,
    'height' => $size,
];
$canvas = Plotter::make(
    canvasSize: ['width' => $size, 'height' => $size],
    viewport: $viewport,
    plotarea: $plotarea,
);

// plotting grids and axis
$fontPath = '/usr/share/fonts/opentype/ipafont-mincho/ipamp.ttf';
$gridInterval = 0.5;
$canvas
    ->plotGridHorizon($gridInterval, 1, '#ccffcc')
    ->plotGridVertical($gridInterval, 1, '#ccffcc')
    ->plotGridValuesX($gridInterval * 2)
    ->plotGridValuesY($gridInterval * 2)
    ->plotAxisX()
    ->plotAxisY()
    ->plotAxisLabelO('O', size: 18, fontPath: $fontPath)
    ->plotAxisLabelX('M', size: 18, fontPath: $fontPath, position: 'upper')
    ->plotAxisLabelY('N', size: 18, fontPath: $fontPath, position: 'right');

// plotting logarithmic curve
$dx = 0.1;
for ($x = 0.1; $x < 4; $x += $dx) {
    $canvas->plotline(
        x1: $x,
        y1: log($x, 2),
        x2: $x + $dx,
        y2: log($x + $dx, 2),
        width: 1,
        color: '#0000ff',
    );
}

// plot formula
$canvas->plotText(
    text: 'N=logM/log2',
    x: 3.9,
    y: 2.1,
    fontSize: 24,
    fontPath: $fontPath,
    fontColor: '#333333',
    align: 'right',
    valign: 'bottom',
);

// plot specific points and auxiliary lines
$x = 2;
$y = log($x, 2);
$canvas
    ->plotLine($x, $y, 0, $y, 1, '#ff0000', [8, 6])
    ->plotLine($x, $y, $x, 0, 1, '#ff0000', [8, 6])
    ->plotCircle($x, $y, 0.1, '#ff0000', 0)
    ->plotText("({$x}, {$y})", 2.25, 1.0, 24, $fontPath, '#333333', 'left', 'top');

// saving into the file
$canvas->save(__DIR__ . '/img/GraphLogCurve.png');
