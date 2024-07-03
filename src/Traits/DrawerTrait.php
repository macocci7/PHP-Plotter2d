<?php

namespace Macocci7\PhpPlotter2d\Traits;

use Intervention\Image\Geometry\Factories\BezierFactory;
use Intervention\Image\Geometry\Factories\CircleFactory;
use Intervention\Image\Geometry\Factories\EllipseFactory;
use Intervention\Image\Geometry\Factories\LineFactory;
use Intervention\Image\Geometry\Factories\PolygonFactory;
use Intervention\Image\Geometry\Factories\RectangleFactory;
use Intervention\Image\Typography\FontFactory;
use Macocci7\PhpPlotter2d\Enums\Position;

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
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
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
        $cY = $y1 < $y2 ? 1 : -1;
        $m = $cX === 0 ? null : ($y2 - $y1) / ($x2 - $x1);
        $goal = (int) round(sqrt(($x2 - $x1) ** 2 + ($y2 - $y1) ** 2));
        $dashCount = count($dash);
        $i = 0;
        $l = 0;
        while ($l < $goal) {
            // calculate only when $i is even
            if (($i % 2) === 0) {
                // start point
                $dx = is_null($m) ? 0        : $l * sqrt(1 / (1 + $m ** 2)) * $cX;
                $dy = is_null($m) ? $l * $cY : $l * sqrt(1 / (1 + $m ** 2)) * $m;
                $x3 = $x1 + $dx;
                $y3 = $y1 + $dy;
            }

            // total length
            $i = $i % $dashCount;
            $l += $dash[$i];
            if ($l > $goal) {
                $l = $goal;
            }

            if (($i % 2) === 0) {
                // end point
                $dx = is_null($m) ? 0        : $l * sqrt(1 / (1 + $m ** 2)) * $cX;
                $dy = is_null($m) ? $l * $cY : $l * sqrt(1 / (1 + $m ** 2)) * $m;
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
     * @param   int[]       $dash = []
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
        array $dash = [],
    ) {
        if (count($dash) > 0) {
            return $this->drawDashedBox(
                $x1,
                $y1,
                $x2,
                $y2,
                $backgroundColor,
                $borderWidth,
                $borderColor,
                $dash,
            );
        }
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
     * draws a dashed box
     *
     * @param   int         $x1
     * @param   int         $y1
     * @param   int         $x2
     * @param   int         $y2
     * @param   string|null $backgroundColor = null
     * @param   int         $borderWidth = 1
     * @param   string|null $borderColor = '#000000'
     * @param   int[]       $dash = []
     * @return  self
     */
    public function drawDashedBox(
        int $x1,
        int $y1,
        int $x2,
        int $y2,
        string|null $backgroundColor = null,
        int $borderWidth = 1,
        string|null $borderColor = '#000000',
        array $dash = [],
    ) {
        // background
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
            ) {
                $rectangle->size($width, $height);
                $rectangle->background($backgroundColor);
            }
        );

        // top side
        $this->drawDashedLine(
            $x1,
            $y1,
            $x2,
            $y1,
            $borderWidth,
            $borderColor,
            $dash,
        );

        // right side
        $this->drawDashedLine(
            $x2,
            $y1,
            $x2,
            $y2,
            $borderWidth,
            $borderColor,
            $dash,
        );

        // bottom side
        $this->drawDashedLine(
            $x2,
            $y2,
            $x1,
            $y2,
            $borderWidth,
            $borderColor,
            $dash,
        );

        // left side
        $this->drawDashedLine(
            $x1,
            $y2,
            $x1,
            $y1,
            $borderWidth,
            $borderColor,
            $dash,
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
     * draws an arc
     *
     * @param   int         $x
     * @param   int         $y
     * @param   int         $radius
     * @param   int|float   $degrees1
     * @param   int|float   $degrees2
     * @param   string|null $backgroundColor = null
     * @param   int         $borderWidth = 1
     * @param   string|null $borderColor = '#000000'
     * @param   bool        $withSides = false
     * @return  self
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function drawArc(
        int $x,
        int $y,
        int $radius,
        int|float $degrees1,
        int|float $degrees2,
        string|null $backgroundColor = null,
        int $borderWidth = 1,
        string|null $borderColor = '#000000',
        bool $withSides = false,
    ) {
        // r: radius
        // l: length of arc
        // d: degrees
        // t: radian
        //      def.) l = rt
        //          => t = l / r
        //      def.) t:2π = d:360
        //          => 360t = 2πd
        //          => t = (π/180)d
        //          => d = (180/π)t
        //               = (180l/πr)
        $goal = $degrees1 < $degrees2 ? $degrees2 : $degrees1;
        $degrees = $degrees1 < $degrees2 ? $degrees1 : $degrees2;
        $dd = 2 * 180 / (M_PI * $radius);
        // starting point
        $points = [
            [
                (int) round($x + $radius * cos(deg2rad($degrees))),
                (int) round($y - $radius * sin(deg2rad($degrees))),
            ],
        ];
        // calculate coordinates of points to draw
        while ($degrees < $goal) {
            $degrees += $dd;
            if ($degrees > $goal) {
                $degrees = $goal;
            }
            $x2 = (int) round($x + $radius * cos(deg2rad($degrees)));
            $y2 = (int) round($y - $radius * sin(deg2rad($degrees)));
            $points[] = [$x2, $y2];
        }
        // paint inside
        $this->drawPolygon(
            points: [[$x, $y], ...$points],
            backgroundColor: $backgroundColor,
            borderWidth: 0,
        );
        // drawing an arc
        if ($withSides) {
            // with sides
            $this->drawPolygon(
                points: [[$x, $y], ...$points],
                backgroundColor: null,
                borderWidth: $borderWidth,
                borderColor: $borderColor,
            );
        } else {
            // without sides
            $count = count($points);
            for ($i = 0; $i < $count - 1; $i++) {
                $this->drawLine(
                    x1: $points[$i][0],
                    y1: $points[$i][1],
                    x2: $points[$i + 1][0],
                    y2: $points[$i + 1][1],
                    width: $borderWidth,
                    color: $borderColor,
                );
            }
        }
        return $this;
    }

    /**
     * draws an elliptical arc
     *
     * @param   int         $x
     * @param   int         $y
     * @param   int         $width
     * @param   int         $height
     * @param   int|float   $degrees1
     * @param   int|float   $degrees2
     * @param   string|null $backgroundColor = null
     * @param   int         $borderWidth = 1
     * @param   string|null $borderColor = '#000000'
     * @param   bool        $withSides = false
     * @return  self
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public function drawEllipticalArc(
        int $x,
        int $y,
        int $width,     // width of the ellipse
        int $height,    // height of the ellipse
        int|float $degrees1,
        int|float $degrees2,
        string|null $backgroundColor = null,
        int $borderWidth = 1,
        string|null $borderColor = '#000000',
        bool $withSides = false,
    ) {
        // r: radius
        // l: length of arc
        // d: degrees
        // t: radian
        //      def.) l = rt
        //          => t = l / r
        //      def.) t:2π = d:360
        //          => 360t = 2πd
        //          => t = (π/180)d
        //          => d = (180/π)t
        //               = (180l/πr)
        $radius = $width < $height
            ? (int) round($height / 2)
            : (int) round($width / 2);
        $rateX = $width < $height ? $width / $height : 1;
        $rateY = $height < $width ? $height / $width : 1;
        $goal = $degrees1 < $degrees2 ? $degrees2 : $degrees1;
        $degrees = $degrees1 < $degrees2 ? $degrees1 : $degrees2;
        $dd = 2 * 180 / (M_PI * $radius);
        // starting point
        $points = [
            [
                (int) round($x + $radius * cos(deg2rad($degrees)) * $rateX),
                (int) round($y - $radius * sin(deg2rad($degrees)) * $rateY),
            ],
        ];
        // calculate coordinates of points to draw
        while ($degrees < $goal) {
            $degrees += $dd;
            if ($degrees > $goal) {
                $degrees = $goal;
            }
            $x2 = (int) round($x + $radius * cos(deg2rad($degrees)) * $rateX);
            $y2 = (int) round($y - $radius * sin(deg2rad($degrees)) * $rateY);
            $points[] = [$x2, $y2];
        }
        // paint inside
        $this->drawPolygon(
            points: [[$x, $y], ...$points],
            backgroundColor: $backgroundColor,
            borderWidth: 0,
        );
        // drawing an arc
        if ($withSides) {
            // with sides
            $this->drawPolygon(
                points: [[$x, $y], ...$points],
                backgroundColor: null,
                borderWidth: $borderWidth,
                borderColor: $borderColor,
            );
        } else {
            // without sides
            $count = count($points);
            for ($i = 0; $i < $count - 1; $i++) {
                $this->drawLine(
                    x1: $points[$i][0],
                    y1: $points[$i][1],
                    x2: $points[$i + 1][0],
                    y2: $points[$i + 1][1],
                    width: $borderWidth,
                    color: $borderColor,
                );
            }
        }
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
     * @param   int|float   $angle = 0
     * @param   int         $offsetX = 0
     * @param   int         $offsetY = 0
     * @return  self
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
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
        int|float $angle = 0,   // degrees to rotate the text counterclockwise
        int $offsetX = 0,   // x-offset after rotation from left edge
        int $offsetY = 0,   // y-offset after rotation from top edge
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
        $image = $this->imageManager->create(
            $this->size['width'],
            $this->size['height'],
        );
        $image->text(
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
            },
        );
        $image->rotate($angle);
        $this->image->place(
            element: $image,
            position: Position::composit($align, $valign),
            offset_x: $offsetX,
            offset_y: $offsetY,
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
