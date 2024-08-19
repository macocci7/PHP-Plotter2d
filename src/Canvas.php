<?php

namespace Macocci7\PhpPlotter2d;

use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;
use Macocci7\PhpPlotter2d\Helpers\Config;

// phpcs:disable
/**
 * @method  Plotarea    plotPixel(int|float $x, int|float $y, string $color)
 * @method  Plotarea    plotLine(int|float $x1, int|float $y1, int|float $x2, int|float $y2, int $width = 1, string $color = '#000000', array $dash = [])
 * @method  Plotarea    plotBox(int|float $x1, int|float $y1, int|float $x2, int|float $y2, string|null $backgroundColor = null, int $borderWidth = 1, string|null $borderColor = '#000000', array $dash = [])
 * @method  Plotarea    plotCircle(int|float $x, int|float $y, int|float $radius, string|null $backgroundColor = null, int $borderWidth = 1, string|null $borderColor = '#000000')
 * @method  Plotarea    plotPerfectCircle(int|float $x, int|float $y, int $radius, string|null $backgroundColor = null, int $borderWidth = 1, string|null $borderColor = '#000000')
 * @method  Plotarea    plotEllipse(int|float $x, int|float $y, int|float $width, int|float $height, string|null $backgroundColor = null, int $borderWidth = 1, string|null $borderColor = '#000000')
 * @method  Plotarea    plotArc(int|float $x, int|float $y, int|float $radius, int|float $degrees1, int|float $degrees2, string|null $backgroundColor = null, int $borderWidth = 1, string|null $borderColor = '#000000', bool $withSides = false)
 * @method  Plotarea    plotPolygon(array $points, string|null $backgroundColor, int $borderWidth, string|null $borderColor)
 * @method  Plotarea    plotBezier(array $points, string|null $backgroundColor, int $borderWidth, string|null $borderColor)
 * @method  Plotarea    plotText(string $text, int|float $x, int|float $y, int $fontSize = 0, string $fontPath = '', string $fontColor = '', string $align = 'left', string $valign = 'bottom', int|float $angle = 0, int|float $offsetX = 0, int|float $offsetY = 0, string $rotateAlign = 'center', string $rotateValign = 'middle')
 * @method  Plotarea    plotFill(int|float $x, int|float $y, string $color)
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
// phpcs:enable
class Canvas
{
    use Traits\DrawerTrait;
    use Traits\JudgeTrait;

    protected int $CANVAS_WIDTH_LIMIT_LOWER;
    protected int $CANVAS_HEIGHT_LIMIT_LOWER;
    protected string $fontPath;
    protected int $fontSize;
    protected string $fontColor;

    protected string $imageDriver = 'imagick';
    protected ImageManager $imageManager;
    protected ImageInterface $image;

    protected Plotarea $plotareaClass;
    protected int|float $defaultPlotareaRateX;
    protected int|float $defaultPlotareaRateY;

    /**
     * constructor
     *
     * @param   array<string, int>  $size
     * @param   array<string, array<int, int|float>>    $viewport
     * @param   array<string, int|string|null|int[]>    $plotarea
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
        $this->setDefaultPlotarea();
        $this->plotareaClass = (new Plotarea(
            size: [
                'width' => $this->plotarea['width'],
                'height' => $this->plotarea['height'],
            ],
            viewport: $this->viewport,
            backgroundColor: array_key_exists('backgroundColor', $this->plotarea)
                ? $this->plotarea['backgroundColor']
                : '#ffffff',
        ))->create();
    }

    /**
     * calls plot*() methods of Plotarea class
     *
     * @param   string                  $name
     * @param   array<string, mixed>    $arguments
     * @return  self
     * @thrown  \Exception
     */
    public function __call(string $name, array $arguments)
    {
        if (str_starts_with($name, 'plot')) {
            $this->plotareaClass->{$name}(...$arguments);
            $this->placePlotarea();
            return $this;
        }
        throw new \Exception("Call to Undefined method {$name}.");
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
            'defaultPlotareaRateX',
            'defaultPlotareaRateY',
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
        $rateX = $this->defaultPlotareaRateX;
        $rateY = $this->defaultPlotareaRateY;
        $plotarea = $this->plotarea;
        if (!array_key_exists('offset', $plotarea)) {
            $plotarea['offset'] = [
                (int) round($this->size['width']  * (1 - $rateX) / 2),
                (int) round($this->size['height'] * (1 - $rateY) / 2),
            ];
        }
        if (!array_key_exists('width', $plotarea)) {
            $plotarea['width']  = (int) round($this->size['width'] * $rateX);
        }
        if (!array_key_exists('height', $plotarea)) {
            $plotarea['height'] = (int) round($this->size['height'] * $rateY);
        }
        $this->plotarea = $plotarea;
    }

    /**
     * returns transformer
     *
     * @return  Transformer
     */
    public function getTransformer()
    {
        return $this->plotareaClass->getTransformer();
    }

    /**
     * retunns the plotarea
     *
     * @return  array<string, int|string|null|int[]>
     */
    public function getPlotarea()
    {
        return $this->plotarea;
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
     * places(overwrites) the plotarea on the canvas
     *
     */
    private function placePlotarea(): void
    {
        $this->image->place(
            element: $this->plotareaClass->getImage(),
            position: 'top-left',
            offset_x: $this->plotarea['offset'][0],
            offset_y: $this->plotarea['offset'][1],
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
