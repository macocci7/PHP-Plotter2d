<?php

declare(strict_types=1);

namespace Macocci7\PhpPlotter2d;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Macocci7\PhpPlotter2d\Enums\Position;

/**
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
final class PositionTest extends TestCase
{
    protected array $positions = [
        'Top' => 'top',
        'Middle' => 'middle',
        'Bottom' => 'bottom',
        'Left' => 'left',
        'Center' => 'center',
        'Right' => 'right',
        'Upper' => 'upper',
        'Lower' => 'lower',
    ];

    public function test_cases_can_return_cases_correctly(): void
    {
        $this->assertSame(array_keys($this->positions), Position::names());
    }

    public function test_values_can_return_values_correctly(): void
    {
        $this->assertSame(array_values($this->positions), Position::values());
    }

    public function test_asArray_can_return_array_correctly(): void
    {
        $this->assertSame($this->positions, Position::asArray());
    }

    public function test_get_can_return_enum_correctly(): void
    {
        foreach ($this->positions as $key => $value) {
            $enum = Position::get($value);
            $this->assertSame($key, $enum->name);
        }
    }

    public static function provides_composit_can_return_correct_composit_position(): array
    {
        return [
            ['align' => '', 'valign' => '', 'expected' => null, ],
            ['align' => 'left', 'valign' => '', 'expected' => null, ],
            ['align' => '', 'valign' => 'top', 'expected' => null, ],
            ['align' => 'middle', 'valign' => 'top', 'expected' => null, ],
            ['align' => 'center', 'valign' => 'center', 'expected' => null, ],
            ['align' => 'left', 'valign' => 'upper', 'expected' => null, ],
            ['align' => 'left', 'valign' => 'lower', 'expected' => null, ],
            ['align' => 'left', 'valign' => 'top', 'expected' => 'top-left', ],
            ['align' => 'center', 'valign' => 'top', 'expected' => 'top', ],
            ['align' => 'right', 'valign' => 'top', 'expected' => 'top-right', ],
            ['align' => 'left', 'valign' => 'middle', 'expected' => 'left', ],
            ['align' => 'center', 'valign' => 'middle', 'expected' => 'center', ],
            ['align' => 'right', 'valign' => 'middle', 'expected' => 'right', ],
            ['align' => 'left', 'valign' => 'bottom', 'expected' => 'bottom-left', ],
            ['align' => 'center', 'valign' => 'bottom', 'expected' => 'bottom', ],
            ['align' => 'right', 'valign' => 'bottom', 'expected' => 'bottom-right', ],
        ];
    }

    #[DataProvider('provides_composit_can_return_correct_composit_position')]
    public function test_composit_can_return_correct_composit_position(string $align, string $valign, string|null $expected): void
    {
        $this->assertSame($expected, Position::composit($align, $valign));
    }
}
