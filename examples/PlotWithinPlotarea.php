<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpPlotter2d\Plotter;

$canvasSize = ['width' => 600, 'height' => 400];
$viewport = ['x' => [-3.5, 5.5], 'y' => [-3.5, 5.5]];
$plotarea = [
    //'offset' => [90, 80],
    //'width' => 420,
    //'height' => 280,
    //'backgroundColor' => null, // transparent
    'placeAutomatically' => false,
];

$canvas = Plotter::make(
    canvasSize: $canvasSize,
    viewport: $viewport,
    plotarea: $plotarea,
    backgroundColor: '#ccddff',
);

// getting the instance of the transformer
$transformer = $canvas->getTransformer();
$coords = $transformer->getCoords([
    [$viewport['x'][0], $viewport['y'][1]],
    [$viewport['x'][1], $viewport['y'][0]],
]);
$offset = $canvas->getPlotarea()['offset'];

// plotting and drawing
$canvas
    ->plotFill(0, 0, '#dddddd')
    ->plotGridHorizon()
    ->plotGridVertical()
    ->plotAxisX()
    ->plotAxisY()
    ->plotAxisLabelO(quadrant: 4)
    ->plotAxisLabelX(position: 'upper')
    ->plotAxisLabelY(position: 'right')
    ->plotScaleX()
    ->plotScaleY()
    ->plotGridValuesX()
    ->plotGridValuesY()
    ->plotPixel(-3, 4, '#ff0000')
    ->plotBox(4, 3, 6, 2, '#ffffcc', 1, '#0000ff')
    ->plotBox(0.5, 4.5, 2.5, 3.5, '#ffcccc', 1, '#ff0000', [8, 4, 2, 4])
    ->plotCircle(5, -2.5, 1.5, '#ccccff', 1, '#0000ff')
    ->plotEllipse(-3, 4.5, 1.5, 3, '#ffccff', 1, '#ff00ff')
    ->plotArc(0, 0, 2, 0, 45, '#ccddff', 1, '#0000cc', true)
    // solid line
    ->plotLine(-4, -4, 6, 6, 1, '#0000ff')
    // dashed line
    ->plotLine(-4, -4, 6, 0, 1, '#ff0000', [8, 4, 2, 4])
    ->plotPerfectCircle(
        x: 2 * cos(deg2rad(45)),
        y: 2 * sin(deg2rad(45)),
        radius: 8,
        backgroundColor: '#ff0000',
        borderWidth: 1,
        borderColor: '#ff0000',
    )
    ->plotPolygon(
        points: [[-4, -1], [-3, 2.5], [-2, 0.5], [-1, 4]],
        backgroundColor: '#ffff99',
        borderWidth: 1,
        borderColor: '#ff9900',
    )
    ->plotBezier(
        points: [[0, -4], [1, -1], [2, -5], [3, -2]],
        backgroundColor: '#ccffcc',
        borderWidth: 1,
        borderColor: '#009900',
    )
    ->plotText('y = x', 3, 5, 24)
    ->placePlotarea()
    ->drawText('Plotting within the Plotarea', 90, 20, 34, '', '#333333', 'left', 'top')
    // frame of the ploarea
    ->drawBox(
        x1: $coords[0][0] + $offset[0],
        y1: $coords[0][1] + $offset[1],
        x2: $coords[1][0] + $offset[0],
        y2: $coords[1][1] + $offset[1],
    )
    ->save(__DIR__ . '/img/PlotWithinPlotarea.png');
