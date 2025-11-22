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
        'x' => [-8, 8],     // required
        'y' => [-5, 5],     // required
    ],
    /*
    plotarea: [ // optional
        // 20pix from left edge, 30pix from top edge
        // default=(10% of the canvas)
        'offset' => [20, 30],
        'width' => 640, // in pix, default=(80% of the canvas)
        'height' => 360 // in pix, default=(80% of the canvas)
    ],
    */
    backgroundColor: '#0000cc',  // optional, default='#ffffff'
);
$canvas
    // plotting inside the plotarea
    ->plotBox(-8, 5, 8, -5, '#cccccc', 2, '#009900')
    ->plotPixel(5, -4.5, '#ff0000')
    ->plotLine(-8, -5, 8, 5, 2, '#ff6600')
    ->plotCircle(0, 0, 3.6, '#ff9999', 2, '#ff0000')
    ->plotEllipse(1.5, -4.8, 4.5, 2.5, '#ccccff', 2, '#000099')
    ->plotPolygon(
        points: [
            [-6, 1.5],
            [-9.5, -2.8],
            [-5, 0],
            [-8, 0.5],
        ],
        backgroundColor: '#ffff00',
        borderWidth: 2,
        borderColor: '#ff6600',
    )
    ->plotBezier(
        points: [
            [3, -1.5],
            [5, -4.5],
            [7, 1.5],
            [9, -2.5],
        ],
        backgroundColor: '#99ff99',
        borderWidth: 2,
        borderColor: '#009900',
    )
    ->plotFill(0.5, -2.5, '#ffffff')
    ->plotLine(-8, 5, 8, -5, 1, '#0000ff', dash: [8, 4, 2, 4])
    ->plotLine(-8, -2.8, 8, -2.8, 1, '#009900', dash: [8, 4, 2, 4])
    ->plotText("Hi, guys! How's it going with you, today?", -7, 3, 32, '', '#006600')
    ->plotGridHorizon()
    ->plotGridVertical()
    ->plotGridValuesX()
    ->plotGridValuesY()
    ->plotAxisX()
    ->plotAxisY()
    ->plotAxisLabelX('x', 16, '#000000', 'lower')
    ->plotAxisLabelY('y', 16, '#000000', 'left')
    ->plotAxisLabelO('O', 16, '#000000', 3)
    // drawing on the canvas, not just in the plotarea
    ->drawPolygon(
        points: [
            [-20, 20],
            [200, 180],
            [120, 20],
            [20, 120],
        ],
        backgroundColor: '#ffff00',
        borderWidth: 3,
        borderColor: '#ff6600',
    )
    ->drawBezier(
        points: [
            [-50, 600],
            [150, 360],
            [240, 600],
            [300, 440],
        ],
        backgroundColor: '#00cc00',
        borderWidth: 2,
        borderColor: '#006600',
    )
    ->drawText('Just a Graffiti', 300, 20, 32, fontColor: '#ffffff', valign: 'top')
    ->save(__DIR__ . '/img/Graffiti.png');
