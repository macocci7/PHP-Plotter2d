<?php

namespace Macocci7\PhpPlotter2d\Traits;

trait AxisTrait
{
    /**
     * plots x-axis
     *
     * @param   int     $width = 0
     * @param   string  $color = '#000000'
     * @return  self
     */
    public function plotAxisX(
        int $width = 1,
        string $color = '#000000',
    ) {
        $this->plotLine(
            $this->viewport['x'][0],
            0,
            $this->viewport['x'][1],
            0,
            $width,
            $color,
        );
        return $this;
    }

    public function plotAxisY(
        int $width = 1,
        string $color = '#000000',
    ) {
        $this->plotLine(
            0,
            $this->viewport['y'][0],
            0,
            $this->viewport['y'][1],
            $width,
            $color,
        );
        return $this;
    }
}
