<?php

namespace Macocci7\PhpPlotter2d;

class Plotter
{
    /**
     * constructor
     *
     * @param   array<string, int>  $canvasSize
     * @param   array<string, int[]>    $viewport
     * @param   array<string, int|array<int, int>>  $plotarea
     * @param   string|null $backgroundColor
     */
    public function __construct(
        private array $canvasSize,
        private array $viewport,
        private array $plotarea = [],
        private string|null $backgroundColor = '#ffffff',
    ) {
    }

    /**
     * creates a canvas
     *
     * @return  Canvas
     */
    public function createCanvas()
    {
        return (new Canvas(
            size: $this->canvasSize,
            viewport: $this->viewport,
            plotarea: $this->plotarea,
            backgroundColor: $this->backgroundColor,
        ))->create();
    }

    /**
     * creates and returns a canvas
     *
     * @param   array<string, int>  $canvasSize
     * @param   array<string, array<int, int|float>>    $viewport
     * @param   array<string, int|array<int, int>>  $plotarea
     * @return  Canvas
     */
    public static function make(
        array $canvasSize,
        array $viewport,
        array $plotarea = [],
        string|null $backgroundColor = '#ffffff',
    ) {
        return (new Plotter(
            $canvasSize,
            $viewport, 
            $plotarea,
            $backgroundColor
        ))
            ->createCanvas();
    }
}
