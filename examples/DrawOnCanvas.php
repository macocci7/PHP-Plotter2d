<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpPlotter2d\Plotter;

$canvas = Plotter::make(
    canvasSize: [
        'width' => 400,
        'height' => 300,
    ],
);

$fontPath = '/usr/share/fonts/truetype/freefont/FreeSansBoldOblique.ttf';
$canvas
    ->fill(10, 10, '#ddeeff')
    ->drawPixel(380, 50, '#ff0000')
    // solid line
    ->drawLine(50, 250, 350, 50, 1, '#0000ff')
    // dashed line
    ->drawLine(50, 250, 350, 200, 2, '#009900', [8, 4, 2, 4])
    ->drawBox(30, 10, 370, 70, '#ffffff', 2, '#0000ff')
    ->drawCircle(50, 250, 20, '#ccccff', 2, '#000099')
    ->drawEllipse(200, 190, 40, 70, '#ffccff', 2, '#ff66ff')
    ->drawPolygon(
        points: [[340, 60], [250, 220], [290, 80], [310, 200]],
        backgroundColor: '#ffff66',
        borderWidth: 2,
        borderColor: '#ff9900',
    )
    ->drawBezier(
        points: [[50, 180], [80, 100], [110, 220], [150, 80]],
        backgroundColor: '#ccffcc',
        borderWidth: 2,
        borderColor: '#009900',
    )
    ->drawText('PLOTTER2D', 60, 60, fontColor: '#666666', fontSize: 48, fontPath: $fontPath)
    ->drawText(
        text: 'Powered by intervention/iamge',
        x: 80,
        y: 20,
        fontColor: '#666666',
        fontSize: 16,
        fontPath: $fontPath,
        align: 'left',
        valign: 'top',
        angle: 90,
        offsetX: 360,
        offsetY: -40,
    )
    ->save('img/DrawOnCanvas.png');
