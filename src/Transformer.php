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
     * @param   array<string, int>          $plotarea
     */
    public function __construct(
        protected array $viewport,
        protected array $plotarea,
    ) {
    }

    /**
     * returns the tranformation rate in the x direction
     *
     * @return  int|float
     */
    public function getRateX()
    {
        $wVP = $this->viewport['x'][1] - $this->viewport['x'][0];
        $wPA = $this->plotarea['width'];
        return $wPA / $wVP;
    }

    /**
     * returns the transformation rate in the y direction
     *
     * @return  int|float
     */
    public function getRateY()
    {
        $hVP = $this->viewport['y'][1] - $this->viewport['y'][0];
        $hPA = $this->plotarea['height'];
        return $hPA / $hVP;
    }

    /**
     * returns transformed coordinate
     *
     * @param   int|float   $x
     * @param   int|float   $y
     * @return  array<string, int>
     */
    public function getCoord(int|float $x, int|float $y)
    {
        $hPA = $this->plotarea['height'];
        $rateX = $this->getRateX();
        $rateY = $this->getRateY() * (-1);
        $dx = $x - $this->viewport['x'][0];
        $dy = $y - $this->viewport['y'][0];
        $cx = (int) round($dx * $rateX);
        $cy = (int) round($dy * $rateY) + $hPA;
        return [
            'x' => $cx,
            'y' => $cy,
        ];
    }

    /**
     * returns transformed coordinates
     *
     * @param   array<int, array<int, int|float>>   $points
     * @return  array<int, array<int, int>>
     */
    public function getCoords(array $points)
    {
        $coords = [];
        foreach ($points as $point) {
            $coord = $this->getCoord($point[0], $point[1]);
            $coords[] = [$coord['x'], $coord['y']];
        }
        return $coords;
    }

    /**
     * returns the span in pix in X direction
     *
     * @param   int|float   $span
     * @return  int
     */
    public function getSpanX(int|float $span)
    {
        return round($span * $this->getRateX());
    }

    /**
     * returns the span in pix in y direction
     *
     * @param   int|float   $span
     * @return  int
     */
    public function getSpanY(int|float $span)
    {
        return round($span * $this->getRateY());
    }
}
