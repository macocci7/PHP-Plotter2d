<?php

namespace Macocci7\PhpPlotter2d;

/**
 * Class for Coordinate Transformation
 * from X-Y Coordinate System to Display Coordinate System
 *
 * @author  macocci7 <macocci7@yahoo.co.jp>
 * @license MIT
 */
class Transformer
{
    /**
     * constructor
     *
     * @param   array<string, int|float>    $viewport
     * @param   array<stirng, int>  $plotarea
     */
    public function __construct(
        protected array $viewport,
        protected array $plotarea,
    ) {
    }

    /**
     * returns transformed coordinate
     *
     * @param   int|float   $x
     * @param   int|float   $y
     * @return  array<string, int>
     */
    public function getCoord(int|flot $x, int|float $y)
    {
        $wVP = $this->viewport['x'][1] - $this->viewport['x'][0];
        $hVP = $this->viewport['y'][1] - $this->viewport['y'][0];
        $wPA = $this->plotarea['width'];
        $hPA = $this->plotarea['height'];
        $xRatio = $wPA / $wVP;
        $yRatio = $hPA / $hVP * (-1);
        $dx = $x - $this->viewport['x'][0];
        $dy = $y - $this->viewport['y'][0];
        $xOffset = $this->plotarea['offset'][0];
        $yOffset = $this->plotarea['offset'][1];
        $cx = round($dx * $xRatio) + $xOffset;
        $cy = round($dy * $yRatio) + $yOffset + $hPA;
        echo "-----------------" . PHP_EOL;
        echo "From: ({$x}, {$y})" . PHP_EOL;
        echo "ViewPort: ({$wVP}, {$hVP})" . PHP_EOL;
        echo "PlotArea: ({$wPA}, {$hPA})" . PHP_EOL;
        echo "Ratio: ({$xRatio}, {$yRatio})" . PHP_EOL;
        echo "Coord: ({$cx}, {$cy})" . PHP_EOL;
        return [
            'x' => $cx,
            'y' => $cy,
        ];
    }

    /**
     * returns the span in pix in X direction
     *
     * @param   int|float   $span
     * @return  int
     */
    public function getSpanX(int|float $span)
    {
        $wVP = $this->viewport['x'][1] - $this->viewport['x'][0];
        $wPA = $this->plotarea['width'];
        $xRatio = $wPA / $wVP;
        return round($span * $xRatio);
    }

    /**
     * returns the span in pix in y direction
     *
     * @param   int|float   $span
     * @return  int
     */
    public function getSpanY(int|float $span)
    {
        $hVP = $this->viewport['y'][1] - $this->viewport['y'][0];
        $hPA = $this->plotarea['height'];
        $yRatio = $hPA / $hVP;
        return round($span * $yRatio);
    }
}
