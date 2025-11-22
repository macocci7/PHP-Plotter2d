<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    use Macocci7\PhpPlotter2d\Plotter;

    $size = ['width' => 400, 'height' => 400];
    $viewport = ['x' => [-5, 5], 'y' => [-5, 5]];
    $points = [ // vertices
        [4, 4],     // A
        [-4, 2],    // B
        [-1, 1],    // C
        [-2, -3],   // D
    ];
    $canvas = Plotter::make(
        canvasSize: $size,
        viewport: $viewport,
    );
    $canvas
        ->plotAxisX()
        ->plotAxisY()
        ->plotAxisLabelX(size: 20, position: 'upper')
        ->plotAxisLabelY(size: 20, position: 'right')
        ->plotGridValuesX()
        ->plotGridValuesY()
        ->plotScaleX()
        ->plotScaleY()
        // drawing a quadrilateral: a dart ABCD
        ->plotPolygon(
            points: $points,
            backgroundColor: null,
            borderWidth: 1,
            borderColor: '#000000',
        )
        // diagonal AC
        ->plotLine(
            x1: $points[0][0],
            y1: $points[0][1],
            x2: $points[2][0],
            y2: $points[2][1],
            width: 1,
            color: '#0000ff',
            dash: [4, 4],
        )
        // diagonal BD
        ->plotLine(
            x1: $points[3][0],
            y1: $points[3][1],
            x2: $points[1][0],
            y2: $points[1][1],
            width: 1,
            color: '#0000ff',
            dash: [4, 4],
        )
        // (-4, 2) - (-1, 4)
        ->plotLine(-4, 2, -1, 4, color: '#ff0000', dash:[4, 4])
        // (-4, -3) - (-1, -4)
        ->plotLine(-4, -3, -1, -4, color: '#ff0000', dash:[4, 4])
        // (-2, 3.5) - (-4.5, 3)
        ->plotLine(-2, 3.5, -4.5, 3, color: '#ff0000', dash:[4, 4])
        // (-2, -4.5) - (-4.5, -3.7)
        ->plotLine(-2, -4.5, -4.5, -3.7, color: '#ff0000', dash:[4, 4])
        // (1, 1) - (4, 1)
        ->plotLine(1, 1, 4, 1, color: '#ff0000', dash:[4, 4])
        // (4, -1) - (1, -1)
        ->plotLine(4, -1, 1, -1, color: '#ff0000', dash:[4, 4])
        // (1.5, -1.8) - (1.5, -3.6)
        ->plotLine(1.5, -1.8, 1.5, -3.6, color: '#ff0000', dash:[4, 4])
        // (2.5, -3.8) - (2.5, -2.6)
        ->plotLine(2.5, -3.8, 2.5, -2.6, color: '#ff0000', dash:[4, 4])
        // labels of vertices
        ->plotText('A', $points[0][0] + 0.2, $points[0][1], fontSize: 20, align: 'left', valign: 'middle')
        ->plotText('B', $points[1][0] - 0.2, $points[1][1], fontSize: 20, align: 'right', valign: 'middle')
        ->plotText('C', $points[2][0], $points[2][1] + 0.2, fontSize: 20, align: 'center', valign: 'bottom')
        ->plotText('D', $points[3][0] - 0.2, $points[3][1], fontSize: 20, align: 'right', valign: 'middle')
        // savinng image into the file
        ->save(__DIR__ . '/img/DashedLines.png');
