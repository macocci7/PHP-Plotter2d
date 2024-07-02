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
        'Bottom' => 'Bottom',
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
}
