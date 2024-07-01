<?php

namespace Macocci7\PhpPlotter2d\Traits;

use Macocci7\PhpPlotter2d\Enums\Position;

trait AxisTrait
{
    protected string $axisLabelX;
    protected string $axisLabelY;
    protected string $axisLabelO;
    protected string $axisLabelXPosition;
    protected string $axisLabelYPosition;

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

    /**
     * plots y-axis
     *
     * @param   int     $width = 1
     * @param   string  $color = '#000000'
     * @return  self
     */
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

    /**
     * plots x-label
     *
     * @param   string  $label = 'x'
     * @param   int     $size = 16
     * @param   string  $color = '#000000'
     * @param   string  $position = Position::Lower->value
     * @param   string  $fontPath = ''
     * @return  self
     */
    public function plotAxisLabelX(
        string $label = 'x',
        int $size = 16,
        string $color = '#000000',
        string $position = 'lower',
        string $fontPath = '',
    ) {
        $coord = $this->transformer->getCoord($this->viewport['x'][1], 0);
        $x = $coord['x'] - 8;
        $y = $coord['y'] + (
            match (Position::get($position)) {
                Position::Upper => -8,
                Position::Lower =>  8,
                default => 0,
            }
        );
        $valign = match (Position::get($position)) {
            Position::Upper => Position::Bottom->value,
            Position::Lower => Position::Top->value,
            default => $position,
        };
        $this->drawText(
            text: $label,
            x: $x,
            y: $y,
            fontSize: $size,
            fontPath: $fontPath,
            fontColor: $color,
            align: Position::Right->value,
            valign: $valign,
        );
        return $this;
    }

    /**
     * plots y-label
     *
     * @param   string  $label = 'y'
     * @param   int     $size = 16
     * @param   string  $color = '#000000'
     * @param   string  $position = Position::Left->value
     * @param   string  $fontPath = ''
     * @return  self
     */
    public function plotAxisLabelY(
        string $label = 'y',
        int $size = 16,
        string $color = '#000000',
        string $position = 'left',
        string $fontPath = '',
    ) {
        $coord = $this->transformer->getCoord(0, $this->viewport['y'][1]);
        $x = $coord['x'] + (
            match (Position::get($position)) {
                Position::Left  => -8,
                Position::Right =>  8,
                default => 0,
            }
        );
        $y = $coord['y'] + 8;
        $align = match (Position::get($position)) {
            Position::Left => Position::Right->value,
            Position::Right => Position::Left->value,
            default => $position,
        };
        $this->drawText(
            text: $label,
            x: $x,
            y: $y,
            fontSize: $size,
            fontPath: $fontPath,
            fontColor: $color,
            align: $align,
            valign: Position::Top->value,
        );
        return $this;
    }

    /**
     * plots origin-label
     *
     * @param   string  $label = 'O'
     * @param   int     $size = 16
     * @param   string  $color = '#000000'
     * @param   int     $quadrant = 3
     * @param   string  $fontPath = ''
     * @return  self
     */
    public function plotAxisLabelO(
        string $label = 'O',
        int $size = 16,
        string $color = '#000000',
        int $quadrant = 3,
        string $fontPath = '',
    ) {
        $coord = $this->transformer->getCoord(0, 0);
        $x = $coord['x'] + (match ($quadrant) {
            1, 4 => 8,
            default => -8,
        });
        $y = $coord['y'] + (match ($quadrant) {
            1, 2 => -8,
            default => 8,
        });
        $align = match ($quadrant) {
            1, 4 => Position::Left->value,
            default => Position::Right->value,
        };
        $valign = match ($quadrant) {
            1, 2 => Position::Bottom->value,
            default => Position::Top->value,
        };
        $this->drawText(
            text: $label,
            x: $x,
            y: $y,
            fontSize: $size,
            fontPath: $fontPath,
            fontColor: $color,
            align: $align,
            valign: $valign,
        );
        return $this;
    }
}
