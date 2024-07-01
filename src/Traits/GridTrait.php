<?php

namespace Macocci7\PhpPlotter2d\Traits;

use Macocci7\PhpPlotter2d\Enums\Position;

trait GridTrait
{
    protected int $gridLabelOffsetX = 12;
    protected int $gridLabelOffsetY = 12;

    /**
     * plots horizontal grids
     *
     * @param   int|float   $interval = 0
     * @param   int         $width = 1
     * @param   string      $color = '#999999'
     * @return  self
     */
    public function plotGridHorizon(
        int|float $interval = 0,
        int $width = 1,
        string $color = '#999999',
    ) {
        list($xMin, $xMax) = $this->viewport['x'];
        list($yMin, $yMax) = $this->viewport['y'];
        if ($interval <= 0) {
            $interval = $this->defaultGridInterval($yMin, $yMax);
        }
        $y = ceil($yMin / $interval) * $interval;
        while ($y <= $yMax) {
            $this->plotLine(
                $xMin,
                $y,
                $xMax,
                $y,
                $width,
                $color,
            );
            $y += $interval;
        }
        return $this;
    }

    /**
     * plots vertical grids
     *
     * @param   int|float   $interval = 0
     * @param   int         $width = 1
     * @param   string      $color = '#999999'
     * @return  self
     */
    public function plotGridVertical(
        int|float $interval = 0,
        int $width = 1,
        string $color = '#999999',
    ) {
        list($xMin, $xMax) = $this->viewport['x'];
        list($yMin, $yMax) = $this->viewport['y'];
        if ($interval <= 0) {
            $interval = $this->defaultGridInterval($xMin, $xMax);
        }
        $x = ceil($xMin / $interval) * $interval;
        while ($x <= $xMax) {
            $this->plotLine(
                $x,
                $yMin,
                $x,
                $yMax,
                $width,
                $color,
            );
            $x += $interval;
        }
        return $this;
    }

    /**
     * rounds the grid interval
     *
     * @param   int|float   $interval
     * @return  int|float
     */
    protected function roundGridInterval(int|float $interval)
    {
        $pow10 = pow(10, floor(log10($interval)));
        $fraction = $interval / $pow10;

        if ($fraction < 1.5) {
            return 1 * $pow10;
        } elseif ($fraction < 3) {
            return 2 * $pow10;
        } elseif ($fraction < 7) {
            return 5 * $pow10;
        } else {
            return 10 * $pow10;
        }
    }

    /**
     * returns default grid interval
     *
     * @param   int|float   $min
     * @param   int|float   $max
     * @return  int|float
     */
    protected function defaultGridInterval(int|float $min, int|float $max)
    {
        $range = $max - $min;
        $gridCount = 10;
        $rawGridInterval = $range / $gridCount;

        return $this->roundGridInterval($rawGridInterval);
    }

    /**
     * plots Grid Values on x-axis
     *
     * @param   int|float   $interval = 0
     * @param   int         $size = 1
     * @param   string      $color = '#666666'
     * @param   string      $fontPath = ''
     * @param   string      $position = Position::Lower->value
     * @param   array<int, int|float>   $except = [0]
     * @return  self
     */
    public function plotGridValuesX(
        int|float $interval = 0,
        int $size = 16,
        string $color = '#666666',
        string $fontPath = '',
        string $position = 'lower',
        array $except = [0],
    ) {
        list($xMin, $xMax) = $this->viewport['x'];
        if ($interval <= 0) {
            $interval = $this->defaultGridInterval($xMin, $xMax);
        }
        $x = ceil($xMin / $interval) * $interval;
        while ($x <= $xMax) {
            if (in_array($x, $except)) {
                $x += $interval;
                continue;
            }
            $coord = $this->transformer->getCoord($x, 0);
            $this->drawText(
                text: (string) $x,
                x: $coord['x'],
                y: $coord['y'] + (int) (match (Position::get($position)) {
                    Position::Upper => - round($this->gridLabelOffsetY / 2),
                    default => round($this->gridLabelOffsetY / 2),
                }),
                fontSize: $size,
                fontPath: $fontPath,
                fontColor: $color,
                align: Position::Center->value,
                valign: match (Position::get($position)) {
                    Position::Upper => Position::Bottom->value,
                    default => Position::Top->value,
                },
            );
            $x += $interval;
        }
        return $this;
    }

    /**
     * plots Grid Values on y-axis
     *
     * @param   int|float   $interval = 0
     * @param   int         $size = 1
     * @param   string      $color = '#666666'
     * @param   string      $fontPath = ''
     * @param   string      $position = Position::Left->value
     * @param   array<int, int|float>   $except = [0]
     * @return  self
     */
    public function plotGridValuesY(
        int|float $interval = 0,
        int $size = 16,
        string $color = '#666666',
        string $fontPath = '',
        string $position = 'left',
        array $except = [0],
    ) {
        list($yMin, $yMax) = $this->viewport['y'];
        if ($interval <= 0) {
            $interval = $this->defaultGridInterval($yMin, $yMax);
        }
        $y = ceil($yMin / $interval) * $interval;
        while ($y <= $yMax) {
            if (in_array($y, $except)) {
                $y += $interval;
                continue;
            }
            $coord = $this->transformer->getCoord(0, $y);
            $this->drawText(
                text: (string) $y,
                x: $coord['x'] + (int) (match (Position::get($position)) {
                    Position::Right => round($this->gridLabelOffsetX / 2),
                    default => - round($this->gridLabelOffsetX / 2),
                }),
                y: $coord['y'],
                fontSize: $size,
                fontPath: $fontPath,
                fontColor: $color,
                align: match (Position::get($position)) {
                    Position::Right => Position::Left->value,
                    default => Position::Right->value,
                },
                valign: Position::Middle->value,
            );
            $y += $interval;
        }
        return $this;
    }
}
