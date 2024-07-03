<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpPlotter2d\Plotter;

$canvas = Plotter::make(
    canvasSize: ['width' => 600, 'height' => 400],
    viewport: ['x' => [-3.5, 5.5], 'y' => [-3.5, 5.5]],
    backgroundColor: '#ccddff',
);

$canvas
    ->plotFill(0, 0, '#cccccc')
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
    // solid line
    ->plotLine(-4, -4, 6, 6, 1, '#0000ff')
    // dashed line
    ->plotLine(-4, -4, 6, 0, 1, '#ff0000', [8, 4, 2, 4])
    ->plotBox(4, 3, 6, 2, '#ffffcc', 1, '#0000ff')
    ->plotBox(0.5, 4.5, 2.5, 3.5, '#ffcccc', 1, '#ff0000', [8, 4, 2, 4])
    ->plotCircle(5, -2.5, 1.5, '#ccccff', 1, '#0000ff')
    ->plotPerfectCircle(1.5, 1.5, 8, '#ff0000', 1, '#ff0000')
    ->plotEllipse(-3, 4.5, 1.5, 3, '#ffccff', 1, '#ff00ff')
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
    ->drawText('Plotting within the Plotarea', 90, 20, 34, '', '#333333', 'left', 'top')
    ->save('img/PlotWithinPlotarea.png');
