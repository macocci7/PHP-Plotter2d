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
    ->box(-8, 5, 8, -5, '#999999', 2, '#009900')
    ->line(-8, -5, 8, 5, 2, '#ffff00', )
    ->dot(0, 0, 60, '#ff9999', 2, '#ff0000')
    ->text("Hey! How's it going with you, today?", -7, 3, 32, '', '#006600')
    ->save('img/BasicUsage.png');
