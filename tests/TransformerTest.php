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

    public static function provide_example(): array
    {
        return [
            ['point' => [0, 0], 'expected' => ['x' => 320, 'y' => 180], ],
        ];
    }

    #[DataProvider('provide_example')]
    public function test_example(array $point, array $expected): void
    {
        $t = new Transformer(
            viewport: $this->viewport,
            plotarea: $this->plotarea,
        );
        $this->assertSame($expected, $t->getCoord($point[0], $point[1]));
    }
}
