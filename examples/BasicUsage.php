<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpPlotter2d\Plotter;

$plotter = Plotter::make(
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
$plotter
    // plotting inside the plotarea
    ->plotBox(-8, 5, 8, -5, '#cccccc', 2, '#009900')
    ->plotPixel(5, -4.5, '#ff0000')
    ->plotLine(-8, -5, 8, 5, 2, '#ff6600', )
    ->plotCircle(0, 0, 3.6, '#ff9999', 2, '#ff0000')
    ->plotEllipse(-2.5, -1.8, 3.5, 1.5, '#ccccff', 2, '#000099')
    ->plotPolygon(
        points: [
            [-4, 1.5],
            [-7.5, -2.8],
            [-3, 0],
            [-6, 0.5],
        ],
        backgroundColor: '#ffff00',
        borderWidth: 2,
        borderColor: '#ff6600',
    )
    ->plotBezier(
        points: [
            [1, -1.5],
            [2, -4.5],
            [3, 1.5],
            [4, -2.5],
        ],
        backgroundColor: '#99ff99',
        borderWidth: 2,
        borderColor: '#009900',
    )
    ->plotFill(0, 4.5, '#ffffff')
    ->plotText("Hi, guys! How's it going with you, today?", -7, 3, 32, '', '#006600')
    // drawing outside the plotarea
    ->drawPolygon(
        points: [
            [20, 20],
            [120, 120],
            [120, 20],
            [20, 120],
        ],
        backgroundColor: '#ffff00',
        borderWidth: 3,
        borderColor: '#ff6600',
    )
    ->drawBezier(
        points: [
            [50, 400],
            [150, 260],
            [240, 500],
            [300, 340],
        ],
        backgroundColor: '#00cc00',
        borderWidth: 2,
        borderColor: '#006600',
    )
    ->drawText('Basic Usage', 300, 20, 32, fontColor: '#ffffff', valign: 'top')
    ->save('img/BasicUsage.png');
