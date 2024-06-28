<?php

namespace Macocci7\PhpPlotter2d\Traits;

use Intervention\Image\Geometry\Factories\LineFactory;
use Intervention\Image\Geometry\Factories\RectangleFactory;
use  Intervention\Image\Geometry\Factories\CircleFactory;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use Intervention\Image\Typography\FontFactory;

trait PlotterTrait
{
    /**
     * draws a line on the canvas
     *
     * @param   int|float   $x1
     * @param   int|float   $y1
     * @param   int|float   $x2
     * @param   int|float   $y2
     * @param   int         $width = 1
     * @param   string|null $color = '#000000'
     * @return  self
     */
    public function line(
        int|float $x1,
        int|float $y1,
        int|float $x2,
        int|float $y2,
        int $width = 1,
        string $color = '#000000',
    ) {
        $from = $this->transformer->getCoord($x1, $y1);
        $to = $this->transformer->getCoord($x2, $y2);
        $this->image->drawLine(
            function (LineFactory $line) use ($from, $to, $width, $color) {
                $line->from($from['x'], $from['y']);
                $line->to($to['x'], $to['y']);
                $line->color($color);
                $line->width($width);
            }
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
    public function box(
        int|float   $x1,
        int|float   $y1,
        int|float   $x2,
        int|float   $y2,
        string|null $backgroundColor = null,
        int         $borderWidth = 1,
        string|null $borderColor = '#000000',
    ) {
        $from = $this->transformer->getCoord($x1, $y1);
        $to = $this->transformer->getCoord($x2, $y2);
        $this->image->drawRectangle(
            $from['x'],
            $from['y'],
            function (
                RectangleFactory $rectangle
            ) use (
                $from,
                $to,
                $backgroundColor,
                $borderWidth,
                $borderColor,
            ) {
                $rectangle->size(
                    abs($to['x'] - $from['x']),
                    abs($to['y'] - $from['y']),
                );
                $rectangle->background($backgroundColor);
                $rectangle->border($borderColor, $borderWidth);
            }
        );
        return $this;
    }

    /**
     * draws a circle on the canvas
     *
     * @param   int|float   $x
     * @param   int|float   $y
     * @param   int         $rardius
     * @param   string|null $backgroundColor = null
     * @param   int         $borderWidth = 1
     * @param   string|null $borderColor = '#000000'
     * @return  self
     */
    public function dot(
        int|float   $x,
        int|float   $y,
        int         $radius = 1,    // in pix
        string|null $backgroundColor = null,
        int         $borderWidth = 1,
        string|null $borderColor = '#000000',
    ) {
        $center = $this->transformer->getCoord($x, $y);
        $this->image->drawCircle(
            $center['x'],
            $center['y'],
            function (
                CircleFactory $circle
            ) use (
                $radius,
                $backgroundColor,
                $borderWidth,
                $borderColor,
            ) {
                $circle->radius($radius);
                $circle->background($backgroundColor);
                $circle->border($borderColor, $borderWidth);
            }
        );
        return $this;
    }

    /**
     * draws a text on the canvas
     *
     * @param   string  $text
     * @param   int     $x
     * @param   int     $y
     * @param   int     $fontSize = 0
     * @param   string  $fontPath = ''
     * @param   string  $fontColor = ''
     * @param   string  $align = 'left'
     * @param   string  $vlign = 'bottom'
     * @return  self
     */
    public function text(
        string $text,
        int $x,
        int $y,
        int $fontSize = 0,
        string $fontPath = '',
        string $fontColor = '',
        string $align = 'left',   // 'right', 'center', 'left'(default)
        string $valign = 'bottom',  // 'top', 'middle', 'bottom'(default)
    ) {
        if ($fontSize === 0) {
            $fontSize = $this->fontSize;
        }
        if (strlen($fontPath) === 0) {
            $fontPath = $this->fontPath;
        }
        if (!$this->isColorCode($fontColor)) {
            $fontColor = $this->fontColor;
        }
        $pos = $this->transformer->getCoord($x, $y);
        $this->image->text(
            $text,
            $pos['x'],
            $pos['y'],
            function (
                FontFactory $font
            ) use (
                $fontSize,
                $fontPath,
                $fontColor,
                $align,
                $valign,
            ) {
                $font->filename($fontPath);
                $font->size($fontSize);
                $font->color($fontColor);
                $font->align($align);
                $font->valign($valign);
            }
        );
        return $this;
    }
}
