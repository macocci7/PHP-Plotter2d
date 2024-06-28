<?php

namespace Macocci7\PhpPlotter2d;

use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use Macocci7\PhpPlotter2d\Helpers\Config;

class Canvas
{
    use Traits\JudgeTrait;
    use Traits\PlotterTrait;

    protected int $CANVAS_WIDTH_LIMIT_LOWER;
    protected int $CANVAS_HEIGHT_LIMIT_LOWER;
    protected string $fontPath;
    protected int $fontSize;
    protected string $fontColor;

    protected string $imageDriver = 'imagick';
    protected ImageManager $imageManager;
    protected ImageInterface $image;
    protected Transformer $transformer;

    /**
     * constructor
     *
     * @param   array<string, int>  $size
     * @param   array<string, array<int, int|float>>    $viewport
     * @param   array<string, int|array<int, int>>  $plotarea
     * @param   string|null $backgroundColor
     */
    public function __construct(
        protected array $size,
        protected array $viewport,
        protected array $plotarea = [],
        protected string|null $backgroundColor = '#ffffff',
    ) {
        $this->loadConf();
        $this->imageManager = ImageManager::{$this->imageDriver}();
        if ($this->plotarea === []) {
            $this->setDefaultPlotarea();
        }
        $this->transformer = new Transformer(
            viewport: $this->viewport,
            plotarea: $this->plotarea,
        );
    }

    /**
     * loads config.
     * @return  void
     */
    private function loadConf()
    {
        Config::load();
        $props = [
            'CANVAS_WIDTH_LIMIT_LOWER',
            'CANVAS_HEIGHT_LIMIT_LOWER',
            'imageDriver',
            'fontPath',
            'fontSize',
            'fontColor',
        ];
        foreach ($props as $prop) {
            $this->{$prop} = Config::get('props.' . $prop);
        }
    }

    /**
     * sets default plotarea
     */
    private function setDefaultPlotarea(): void
    {
        $this->plotarea = [
            'offset' => [
                round($this->size['width'] * 0.1),
                round($this->size['height'] * 0.1),
            ],
            'width' => round($this->size['width'] * 0.8),
            'height' => round($this->size['height'] * 0.8),
        ];
    }

    /**
     * creates image
     *
     * @return self
     */
    public function create()
    {
        $this->image = $this->imageManager->create(
            $this->size['width'],
            $this->size['height'],
        );
        if ($this->isColorCode($this->backgroundColor)) {
            $this->image = $this->image->fill($this->backgroundColor);
        }
        return $this;
    }

    /**
     * resizes the canvas size
     * @param   int $width  specify in pix at least 50
     * @param   int $height specify in pix at least 50
     * @return  self
     * @thrown  \Exception
     */
    public function resize(int $width, int $height)
    {
        if ($width < $this->CANVAS_WIDTH_LIMIT_LOWER) {
            throw new \Exception(
                "width is below the lower limit "
                . $this->CANVAS_WIDTH_LIMIT_LOWER
            );
        }
        if ($height < $this->CANVAS_HEIGHT_LIMIT_LOWER) {
            throw new \Exception(
                "height is below the lower limit "
                . $this->CANVAS_HEIGHT_LIMIT_LOWER
            );
        }
        $this->canvasWidth = $width;
        $this->canvasHeight = $height;
        return $this;
    }

    /**
     * clears the canvas
     *
     * @return  Canvas
     */
    public function clear()
    {
        return new Canvas(
            size: $this->size,
            viewport: $this->viewport,
            plotarea: $this->plotarea,
            backgroundColor: $this->backgroundColor,
        );
    }

    /**
     * saves the image into a file
     *
     * @param   string  $path
     */
    public function save(string $path): void
    {
        $this->image->save($path);
    }
}
