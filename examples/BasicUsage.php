<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpPlotter2d\Plotter;

// Creating Instance of Macocci7\PhpPlotter2d\Canvas
$canvas = Plotter::make(
    canvasSize: [
        'width' => 800,     // required
        'height' => 600,    // required
    ],
    viewport: [
        'x' => [-8, 8],     // optional
        'y' => [-5, 5],     // optional
    ],
);

// Plotting (drawing with x-y coordinates within the plotarea)
// and
// Drawing (drawing on the canvas)
$canvas
    // plotting inside the plotarea
    ->plotBox(-8, 5, 8, -5, '#dddddd', 0)
    ->plotLine(-8, -5, 8, 5, 2, '#0000ff')
    ->plotText("y = (8/5)x", 2, 4, 24)
    // Grids
    ->plotGridValuesX()
    ->plotGridValuesY()
    // Axis
    ->plotAxisX()
    ->plotAxisY()
    ->plotAxisLabelO(size: 24, quadrant: 4)
    ->plotAxisLabelX(size: 24)
    ->plotAxisLabelY(size: 24)
    // Scales
    ->plotScaleX()
    ->plotScaleY()
    // drawing outside the plotarea
    ->drawText('Basic Usage', 300, 20, 32, valign: 'top')
    ->save(__DIR__ . '/img/BasicUsage.png');
