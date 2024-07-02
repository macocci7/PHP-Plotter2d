<?php

namespace Macocci7\PhpPlotter2d\Traits;

use Intervention\Image\Geometry\Factories\BezierFactory;
use Intervention\Image\Geometry\Factories\CircleFactory;
use Intervention\Image\Geometry\Factories\EllipseFactory;
use Intervention\Image\Geometry\Factories\LineFactory;
use Intervention\Image\Geometry\Factories\PolygonFactory;
use Intervention\Image\Geometry\Factories\RectangleFactory;
use Intervention\Image\Typography\FontFactory;

trait DrawerTrait
{
    /**
     * draws a pixel
     *
     * @param   int     $x
     * @param   int     $y
     * @param   string  $color = '#000000'
     * @return  self
     */
    public function drawPixel(
        int $x,
        int $y,
        string $color = '#000000',
    ) {
        $this->image->drawPixel($x, $y, $color);
        return $this;
    }

    /**
     * draws a line
     *
     * @param   int     $x1
     * @param   int     $y1
     * @param   int     $x2
     * @param   int     $y2
     * @param   int     $width = 1
     * @param   string  $color = '#000000'
     * @param   int[]   $dash = []
     * @return  self
     */
    public function drawLine(
        int $x1,
        int $y1,
        int $x2,
        int $y2,
        int $width = 1,
        string $color = '#000000',
        array $dash = [],
    ) {
        if (count($dash) > 0) {
            return $this->drawDashedLine(
                $x1,
                $y1,
                $x2,
                $y2,
                $width,
                $color,
                $dash,
            );
        }
        $this->image->drawLine(
            function (
                LineFactory $line
            ) use (
                $x1,
                $y1,
                $x2,
                $y2,
                $color,
                $width,
            ) {
                $line->from($x1, $y1);
                $line->to($x2, $y2);
                $line->color($color);
                $line->width($width);
            }
        );
        return $this;
    }

    /**
     * draws a dashed line
     *
     * @param   int     $x1
     * @param   int     $y1
     * @param   int     $x2
     * @param   int     $y2
     * @param   int     $width = 1
     * @param   string  $color = '#000000'
     * @param   int[]   $dash = [1, 1]
     * @return  self
     */
    public function drawDashedLine(
        int $x1,
        int $y1,
        int $x2,
        int $y2,
        int $width = 1,
        string $color = '#000000',
        array $dash = [1, 1],
    ) {
        $cX = ($x2 - $x1) == 0 ? 0 : ($x1 < $x2 ? 1 : -1);
        $cY = ($y2 - $y2) == 0 ? 0 : ($y1 < $y2 ? 1 : -1); 
        $m = $cX === 0 ? null : ($y2 - $y1) / ($x2 - $x1);
        $goal = sqrt(($x2 - $x1) ** 2 + ($y2 - $y1) ** 2);
        $dashCount = count($dash);
        $i = 0;
        $l = 0;
        while ($l <= $goal) {
            // calculate only when $i is even
            if (($i % 2) === 0) {
                // start point
                $dx = is_null($m) ? 0  : $cX * $l * sqrt(1 / (1 + $m ** 2));
                $dy = is_null($m) ? $l : $cY * $l * sqrt(1 / (1 + $m ** 2)) * $m;
                $x3 = $x1 + $dx;
                $y3 = $y1 + $dy;
            }

            // total length
            $i = $i % $dashCount;
            $l += $dash[$i];

            if (($i % 2) === 0) {
                // end point
                $dx = is_null($m) ? 0  : $cX * $l * sqrt(1 / (1 + $m ** 2));
                $dy = is_null($m) ? $l : $cY * $l * sqrt(1 / (1 + $m ** 2)) * $m;
                $x4 = $x1 + $dx;
                $y4 = $y1 + $dy;

                // draws a line only when $i is even
                $this->image->drawLine(
                    function (
                        LineFactory $line
                    ) use (
                        $x3,    // @phpstan-ignore-line
                        $y3,    // @phpstan-ignore-line
                        $x4,
                        $y4,
                        $color,
                        $width,
                    ) {
                        $line->from($x3, $y3);  // @phpstan-ignore-line
                        $line->to($x4, $y4);    // @phpstan-ignore-line
                        $line->color($color);
                        $line->width($width);
                    }
                );
            }

            ++$i;
        }
        return $this;
    }

    /**
     * draws a box
     *
     * @param   int         $x1
     * @param   int         $y1
     * @param   int         $x2
     * @param   int         $y2
     * @param   string|null $backgroundColor = null
     * @param   int         $borderWidth = 1
     * @param   string|null $borderColor = '#000000'
     * @return  self
     */
    public function drawBox(
        int $x1,
        int $y1,
        int $x2,
        int $y2,
        string|null $backgroundColor = null,
        int $borderWidth = 1,
        string|null $borderColor = '#000000',
    ) {
        $width  = abs($x2 - $x1) + 1;
        $height = abs($y2 - $y1) + 1;
        $this->image->drawRectangle(
            $x1,
            $y1,
            function (
                RectangleFactory $rectangle
            ) use (
                $width,
                $height,
                $backgroundColor,
                $borderWidth,
                $borderColor,
            ) {
                $rectangle->size($width, $height);
                $rectangle->background($backgroundColor);
                $rectangle->border($borderColor, $borderWidth);
            }
        );
        return $this;
    }

    /**
     * draws a circle
     *
     * @param   int         $x
     * @param   int         $y
     * @param   int         $radius
     * @param   string|null $backgroundColor = null
     * @param   int         $borderWidth = 1
     * @param   string|null $borderColor = '#000000'
     * @return  self
     */
    public function drawCircle(
        int $x,
        int $y,
        int $radius,
        string|null $backgroundColor = null,
        int $borderWidth = 1,
        string|null $borderColor = '#000000',
    ) {
        $this->image->drawCircle(
            $x,
            $y,
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
     * draws an Ellipse
     *
     * @param   int         $x
     * @param   int         $y
     * @param   int         $width
     * @param   int         $height
     * @param   string|null $backgroundColor = null
     * @param   int         $borderWidth = 1
     * @param   string|null $borderColor = '#000000'
     * @return  self
     */
    public function drawEllipse(
        int $x,
        int $y,
        int $width,
        int $height,
        string|null $backgroundColor = null,
        int $borderWidth = 1,
        string|null $borderColor = '#000000',
    ) {
        $this->image->drawEllipse(
            $x,
            $y,
            function (
                EllipseFactory $ellipse
            ) use (
                $width,
                $height,
                $backgroundColor,
                $borderWidth,
                $borderColor,
            ) {
                $ellipse->size($width, $height);
                $ellipse->background($backgroundColor);
                $ellipse->border($borderColor, $borderWidth);
            }
        );
        return $this;
    }

    /**
     * draws a polygon
     *
     * @param   array<int, array<int, int>> $points
     * @param   string|null                 $backgroundColor = null
     * @param   int                         $borderWidth = 1
     * @param   string|null                 $borderColor = '#000000'
     * @return  self
     */
    public function drawPolygon(
        array $points,
        string|null $backgroundColor = null,
        int $borderWidth = 1,
        string|null $borderColor = '#000000',
    ) {
        $this->image->drawPolygon(
            function (
                PolygonFactory $polygon
            ) use (
                $points,
                $backgroundColor,
                $borderWidth,
                $borderColor,
            ) {
                foreach ($points as $point) {
                    $polygon->point($point[0], $point[1]);
                }
                $polygon->background($backgroundColor);
                $polygon->border($borderColor, $borderWidth);
            }
        );
        return $this;
    }

    /**
     * draws a Bezier Curve
     *
     * @param   array<int, array<int, int>> $points
     * @param   string|null                 $backgroundColor = null
     * @param   int                         $borderWidth = 1
     * @param   string|null                 $borderColor = '#000000'
     * @return  self
     */
    public function drawBezier(
        array $points,
        string|null $backgroundColor = null,
        int $borderWidth = 1,
        string|null $borderColor = '#000000',
    ) {
        $this->image->drawBezier(
            function (
                BezierFactory $bezier
            ) use (
                $points,
                $backgroundColor,
                $borderWidth,
                $borderColor,
            ) {
                foreach ($points as $point) {
                    $bezier->point($point[0], $point[1]);
                }
                $bezier->background($backgroundColor);
                $bezier->border($borderColor, $borderWidth);
            }
        );
        return $this;
    }

    /**
     * draws a text
     *
     * @param   string  $text
     * @param   int     $x
     * @param   int     $y
     * @param   int     $fontSize = 0
     * @param   string  $fontPath = ''
     * @param   string  $fontColor = ''
     * @param   string  $align = 'left'
     * @param   string  $valign = 'bottom'
     * @return  self
     */
    public function drawText(
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
        $this->image->text(
            $text,
            $x,
            $y,
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

    /**
     * fills the image with the color
     *
     * @param   int     $x
     * @param   int     $y
     * @param   string  $color
     * @return  self
     */
    public function fill(int $x, int $y, string $color)
    {
        $this->image->fill($color, $x, $y);
        return $this;
    }
}
