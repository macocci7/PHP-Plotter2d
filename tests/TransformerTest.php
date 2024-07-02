<?php

declare(strict_types=1);

namespace Macocci7\PhpPlotter2d;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Macocci7\PhpPlotter2d\Transformer;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class TransformerTest extends TestCase
{
    protected $viewport = [
        'x' => [-8, 8],
        'y' => [-5, 5],
    ];
    protected $plotarea = [
        'offset' => [20, 30],
        'width' => 640, // in pix, default=(80% of the canvas)
        'height' => 360 // in pix, default=(80% of the canvas)
    ];

    public static function provide_getRateX_can_return_value_correctly(): array
    {
        return [
            ['span' => 0, 'expected' => 0, ],
            ['span' => -1, 'expected' => -40, ],
            ['span' => 1, 'expected' => 40, ],
            ['span' => -2, 'expected' => -80, ],
            ['span' => 2, 'expected' => 80, ],
            ['span' => -0.5, 'expected' => -20, ],
            ['span' => 0.5, 'expected' => 20, ],
            ['span' => 0.04, 'expected' => 2, ],
            ['span' => 0.03, 'expected' => 1, ],
        ];
    }

    #[DataProvider('provide_getRateX_can_return_value_correctly')]
    public function test_getRateX_can_return_value_correctly(int|float $span, int $expected): void
    {
        $t = new Transformer(
            viewport: $this->viewport,
            plotarea: $this->plotarea,
        );
        $this->assertSame($expected, $t->getSpanX($span));
    }

    public static function provide_getRateY_can_return_value_correctly(): array
    {
        return [
            ['span' => 0, 'expected' => 0, ],
            ['span' => -1, 'expected' => -36, ],
            ['span' => 1, 'expected' => 36, ],
            ['span' => -2, 'expected' => -72, ],
            ['span' => 2, 'expected' => 72, ],
            ['span' => -0.5, 'expected' => -18, ],
            ['span' => 0.5, 'expected' => 18, ],
            ['span' => 0.05, 'expected' => 2, ],
            ['span' => 0.035, 'expected' => 1, ],
        ];
    }

    #[DataProvider('provide_getRateY_can_return_value_correctly')]
    public function test_getRateY_can_return_value_correctly(int|float $span, int $expected): void
    {
        $t = new Transformer(
            viewport: $this->viewport,
            plotarea: $this->plotarea,
        );
        $this->assertSame($expected, $t->getSpanY($span));
    }

    public static function provide_getCoord_can_return_correct_coords(): array
    {
        return [
            ['point' => [0, 0], 'expected' => ['x' => 320, 'y' => 180], ],
            ['point' => [-8, 5], 'expected' => ['x' => 0, 'y' => 0], ],
            ['point' => [-8, -5], 'expected' => ['x' => 0, 'y' => 360], ],
            ['point' => [8, 5], 'expected' => ['x' => 640, 'y' => 0], ],
            ['point' => [8, -5], 'expected' => ['x' => 640, 'y' => 360], ],
            ['point' => [-10, 6], 'expected' => ['x' => -80, 'y' => -36], ],
            ['point' => [10, -6], 'expected' => ['x' => 720, 'y' => 396], ],
            ['point' => [-1.3, 2.6], 'expected' => ['x' => 268, 'y' => 86], ],
        ];
    }

    #[DataProvider('provide_getCoord_can_return_correct_coords')]
    public function test_getCoord_can_return_correct_coords(array $point, array $expected): void
    {
        $t = new Transformer(
            viewport: $this->viewport,
            plotarea: $this->plotarea,
        );
        $this->assertSame($expected, $t->getCoord($point[0], $point[1]));
    }

    public static function provide_getCoords_can_return_coords_correctly(): array
    {
        return [
            [
                'points' => [[0, 0]],
                'expected' => [[320, 180]],
            ],
            [
                'points' => [[-8, 5]],
                'expected' => [[0, 0]],
            ],
            [
                'points' => [[-8, -5]],
                'expected' => [[0, 360]],
            ],
            [
                'points' => [[8, 5]],
                'expected' => [[640, 0]],
            ],
            [
                'points' => [[8, -5]],
                'expected' => [[640, 360]],
            ],
            [
                'points' => [[-10, 6]],
                'expected' => [[-80, -36]],
            ],
            [
                'points' => [[10, -6]],
                'expected' => [[720, 396]],
            ],
            [
                'points' => [[-1.3, 2.6]],
                'expected' => [[268, 86]],
            ],
            [
                'points' => [[0, 0], [-8, 5], [-8, -5], [8, 5], [8, -5], [-10, 6], [10, -6], [-1.3, 2.6], ],
                'expected' => [[320, 180], [0, 0], [0, 360], [640, 0], [640, 360], [-80, -36], [720, 396], [268, 86]],
            ],
        ];
    }

    #[DataProvider('provide_getCoords_can_return_coords_correctly')]
    public function test_getCoords_can_return_coords_correctly(array $points, array $expected): void
    {
        $t = new Transformer(
            viewport: $this->viewport,
            plotarea: $this->plotarea,
        );
        $this->assertSame($expected, $t->getCoords($points));
    }

    public static function provide_getSpanX_can_return_correct_value(): array
    {
        return [
            ['span' => 0, 'expected' => 0, ],
            ['span' => -1, 'expected' => -40, ],
            ['span' => -2, 'expected' => -80, ],
            ['span' => 1, 'expected' => 40, ],
            ['span' => 2, 'expected' => 80, ],
            ['span' => 0.07, 'expected' => 3, ],
            ['span' => -0.07, 'expected' => -3, ],
            ['span' => 0.03, 'expected' => 1, ],
            ['span' => -0.03, 'expected' => -1, ],
        ];
    }

    #[DataProvider('provide_getSpanX_can_return_correct_value')]
    public function test_getSapnX_can_return_correct_value(int|float $span, int $expected): void
    {
        $t = new Transformer(
            viewport: $this->viewport,
            plotarea: $this->plotarea,
        );
        $this->assertSame($expected, $t->getSpanX($span));
    }

    public static function provide_getSpanY_can_return_correct_value(): array
    {
        return [
            ['span' => 0, 'expected' => 0, ],
            ['span' => -1, 'expected' => -36, ],
            ['span' => -2, 'expected' => -72, ],
            ['span' => 1, 'expected' => 36, ],
            ['span' => 2, 'expected' => 72, ],
            ['span' => 0.07, 'expected' => 3, ],
            ['span' => -0.07, 'expected' => -3, ],
            ['span' => 0.03, 'expected' => 1, ],
            ['span' => -0.03, 'expected' => -1, ],
        ];
    }

    #[DataProvider('provide_getSpanY_can_return_correct_value')]
    public function test_getSapnY_can_return_correct_value(int|float $span, int $expected): void
    {
        $t = new Transformer(
            viewport: $this->viewport,
            plotarea: $this->plotarea,
        );
        $this->assertSame($expected, $t->getSpanY($span));
    }
}
