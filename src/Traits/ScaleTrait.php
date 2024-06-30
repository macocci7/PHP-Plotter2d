<?php

namespace Macocci7\PhpPlotter2d\Traits;

trait ScaleTrait
{
    /**
     * plots scale on x-axis
     *
     * @param   int|float   $interval = 0
     * @param   int         $width = 1
     * @param   int         $length = 6
     * @param   string      $color = '#000000'
     * @return  self
     */
    public function plotScaleX(
        int|float $interval = 0,
        int $width = 1,
        int $length = 6,
        string $color = '#000000',
    ) {
        list($xMin, $xMax) = $this->viewport['x'];
        if ($interval <= 0) {
            $interval = $this->defaultGridInterval($xMin, $xMax);
        }
        $x = ceil($xMin / $interval) * $interval;
        while ($x <= $xMax) {
            $coord = $this->transformer->getCoord($x, 0);
            $this->drawLine(
                $coord['x'],
                $coord['y'] - round($length / 2),
                $coord['x'],
                $coord['y'] + round($length / 2),
                $width,
                $color,
            );
            $x += $interval;
        }
        return $this;
    }

    /**
     * plots scale on y-axis
     *
     * @param   int|float   $interval = 0
     * @param   int         $width = 1
     * @param   int         $length = 6
     * @param   string      $color = '#000000'
     * @return  self
     */
    public function plotScaleY(
        int|float $interval = 0,
        int $width = 1,
        int $length = 6,
        string $color = '#000000',
    ) {
        list($yMin, $yMax) = $this->viewport['y'];
        if ($interval <= 0) {
            $interval = $this->defaultGridInterval($yMin, $yMax);
        }
        $y = ceil($yMin / $interval) * $interval;
        while ($y <= $yMax) {
            $coord = $this->transformer->getCoord(0, $y);
            $this->drawLine(
                $coord['x'] - round($length / 2),
                $coord['y'],
                $coord['x'] + round($length / 2),
                $coord['y'],
                $width,
                $color,
            );
            $y += $interval;
        }
        return $this;
    }
}
