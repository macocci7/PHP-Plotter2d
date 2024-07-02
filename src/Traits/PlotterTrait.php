<?php

namespace Macocci7\PhpPlotter2d\Traits;

trait PlotterTrait
{
    /**
     * plots a pixel
     *
     * @param   int|float   $x
     * @param   int|float   $y
     * @param   string      $color
     * @return  self
     */
    public function plotPixel(
        int|float $x,
        int|float $y,
        string $color,
    ) {
        $coord = $this->transformer->getCoord($x, $y);
        $this->drawPixel($coord['x'], $coord['y'], $color);
        return $this;
    }

    /**
     * draws a line on the canvas
     *
     * @param   int|float   $x1
     * @param   int|float   $y1
     * @param   int|float   $x2
     * @param   int|float   $y2
     * @param   int         $width = 1
     * @param   string      $color = '#000000'
     * @param   int[]       $dash = []
     * @return  self
     */
    public function plotLine(
        int|float $x1,
        int|float $y1,
        int|float $x2,
        int|float $y2,
        int $width = 1,
        string $color = '#000000',
        array $dash = [],
    ) {
        $from = $this->transformer->getCoord($x1, $y1);
        $to = $this->transformer->getCoord($x2, $y2);
        $this->drawLine(
            $from['x'],
            $from['y'],
            $to['x'],
            $to['y'],
            $width,
            $color,
            $dash,
        );
        return $this;
    }

    /**
     * draws a box on the canvas
     *
     * @param   int|float   $x1
     * @param   int|float   $y1
     * @param   int|float   $x2
     * @param   int|float   $y2
     * @param   string|null $backgroundColor = null
     * @param   int         $borderWidth = 1
     * @param   string|null $backgroundColor = '#000000'
     * @return  self
     */
    public function plotBox(
        int|float $x1,
        int|float $y1,
        int|float $x2,
        int|float $y2,
        string|null $backgroundColor = null,
        int $borderWidth = 1,
        string|null $borderColor = '#000000',
    ) {
        $from = $this->transformer->getCoord($x1, $y1);
        $to   = $this->transformer->getCoord($x2, $y2);
        $this->drawBox(
            $from['x'],
            $from['y'],
            $to['x'],
            $to['y'],
            $backgroundColor,
            $borderWidth,
            $borderColor,
        );
        return $this;
    }

    /**
     * plots a circle on the plotarea
     *
     * @param   int|float   $x
     * @param   int|float   $y
     * @param   int|float   $radius
     * @param   string|null $backgroundColor = null
     * @param   int         $borderWidth = 1
     * @param   string|null $borderColor = '#000000'
     * @return  self
     */
    public function plotCircle(
        int|float $x,
        int|float $y,
        int|float $radius,
        string|null $backgroundColor = null,
        int $borderWidth = 1,
        string|null $borderColor = '#000000',
    ) {
        $center = $this->transformer->getCoord($x, $y);
        $width = $this->transformer->getSpanX($radius);
        $height = $this->transformer->getSpanY($radius);
        $this->drawEllipse(
            $center['x'],
            $center['y'],
            $width,
            $height,
            $backgroundColor,
            $borderWidth,
            $borderColor,
        );
        return $this;
    }

    /**
     * plots an ellipse
     *
     * @param   int|float   $x
     * @param   int|float   $y
     * @param   int|float   $width
     * @param   int|float   $height
     * @param   string|null $backgroundColor
     * @param   int         $borderWidth
     * @param   string|null $borderColor
     * @return  self
     */
    public function plotEllipse(
        int|float $x,
        int|float $y,
        int|float $width,
        int|float $height,
        string|null $backgroundColor = null,
        int $borderWidth = 1,
        string|null $borderColor = '#000000',
    ) {
        $coord = $this->transformer->getCoord($x, $y);
        $w = $this->transformer->getSpanX($width);
        $h = $this->transformer->getSpanY($height);
        $this->drawEllipse(
            $coord['x'],
            $coord['y'],
            $w,
            $h,
            $backgroundColor,
            $borderWidth,
            $borderColor,
        );
        return $this;
    }

    /**
     * plots a polygon
     *
     * @param   array<int, array<int, int|float>>   $points
     * @param   string|null                         $backgroundColor
     * @param   int                                 $borderWidth
     * @param   string|null                         $borderColor
     * @return  self
     */
    public function plotPolygon(
        array $points,
        string|null $backgroundColor,
        int $borderWidth,
        string|null $borderColor,
    ) {
        $coords = $this->transformer->getCoords($points);
        $this->drawPolygon(
            $coords,
            $backgroundColor,
            $borderWidth,
            $borderColor,
        );
        return $this;
    }

    /**
     * plots a Bezier Curve
     *
     * @param   array<int, array<int, int|float>>   $points
     * @param   string|null                         $backgroundColor
     * @param   int                                 $borderWidth
     * @param   string|null                         $borderColor
     * @return  self
     */
    public function plotBezier(
        array $points,
        string|null $backgroundColor,
        int $borderWidth,
        string|null $borderColor,
    ) {
        $coords = $this->transformer->getCoords($points);
        $this->drawBezier(
            $coords,
            $backgroundColor,
            $borderWidth,
            $borderColor,
        );
        return $this;
    }

    /**
     * plots a text on the plotarea
     *
     * @param   string      $text
     * @param   int|float   $x
     * @param   int|float   $y
     * @param   int         $fontSize = 0
     * @param   string      $fontPath = ''
     * @param   string      $fontColor = ''
     * @param   string      $align = 'left'
     * @param   string      $valign = 'bottom'
     * @return  self
     */
    public function plotText(
        string $text,
        int|float $x,
        int|float $y,
        int $fontSize = 0,
        string $fontPath = '',
        string $fontColor = '',
        string $align = 'left',   // 'right', 'center', 'left'(default)
        string $valign = 'bottom',  // 'top', 'middle', 'bottom'(default)
    ) {
        $pos = $this->transformer->getCoord($x, $y);
        $this->drawText(
            text: $text,
            x: $pos['x'],
            y: $pos['y'],
            fontSize: $fontSize,
            fontPath: $fontPath,
            fontColor: $fontColor,
            align: $align,
            valign: $valign,
        );
        return $this;
    }

    /**
     * fills the image with the color
     *
     * @param   int|float   $x
     * @param   int|float   $y
     * @param   string      $color
     * @return  self
     */
    public function plotFill(
        int|float $x,
        int|float $y,
        string $color,
    ) {
        $coord = $this->transformer->getCoord($x, $y);
        $this->fill($coord['x'], $coord['y'], $color);
        return $this;
    }
}
