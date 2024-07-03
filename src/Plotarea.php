<?php

namespace Macocci7\PhpPlotter2d;

use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use Macocci7\PhpPlotter2d\Helpers\Config;

/**
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Plotarea
{
    use Traits\AxisTrait;
    use Traits\DrawerTrait;
    use Traits\GridTrait;
    use Traits\JudgeTrait;
    use Traits\PlotterTrait;
    use Traits\ScaleTrait;

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
     * @param   array<string, int>                      $size
     * @param   array<string, array<int, int|float>>    $viewport
     * @param   string|null                             $backgroundColor
     */
    public function __construct(
        protected array $size,
        protected array $viewport,
        protected string|null $backgroundColor = '#ffffff',
    ) {
        $this->loadConf();
        $this->imageManager = ImageManager::{$this->imageDriver}();
        $this->transformer = new Transformer(
            viewport: $this->viewport,
            plotarea: $this->size,
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
     * returns the image
     *
     * @return  ImageInterface
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * returns transformer
     *
     * @return  Transformer
     */
    public function getTransformer()
    {
        return $this->transformer;
    }
}
