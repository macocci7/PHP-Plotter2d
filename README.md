# PHP-Plotter2d (Under Construction)

A PHP Library to plot graphs and figures on a xy(-two-dimensional)-plane.

## 1. Features

`PHP-Plotter2d` provides basic features to plot graphs and figures on a xy(-two-dimensional)-plane.

### 1.1. Canvas

You can draw figures freely on the canvas, such as:
`Pixels`, `Lines`, `Boxes`, `Circles`, `Ellipses`, `Polygons` and `Bezier Curves`.
You can also put `Characters` or `Fill` the canvas with a specific color.
You can save the `Canvas` to a file.

<img src="examples/img/DrawOnCanvas.png" width="400" />

### 1.2. Plotarea

You can put figures  within the `Plotarea` by just specifying the coordinates on the xy-plane without having to consider the pixel coordinates on the image.
`Transformer` automatically maps the coordinates on the xy-plane to pixel coordinates on the image.
`Plotarea` is automatically placed on the `Canvas`.
You can adjust the position and the size of `Plotarea` on the `Canvas`.

<img src="examples/img/PlotWithinPlotarea.png" width="400" />

## 2. Contents

- [1. Features](#1-features)
- 2\. Contents
- [3. Requirements](#3-requirements)
- [4. Installation](#4-installation)
- [5. Usage](#5-usage)
- [6. Examples](#6-example)
- [7. LICENSE](#7-license)

## 3. Requirements

- PHP 8.1 or later
- Imagick PHP Extention
- Composer

## 4. Installation

```bash
composer require macocci7/php-plotter2d
```

## 5. Usage

### 5-1. Basic Usage

To draw figures on the `Canvas`, create an instance of `Canvas` at first.
Use `Plotter::make()` method to get an instance of `Canvas`.
Pass the `width` and `height` of the `Canvas` in the `canvasSize` parameter.

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpPlotter2d\Plotter;

$canvas = Plotter::make(
    canvasSize: ['width' => 800, 'height' => 400],  // required
);
```

Now, you can draw figures on the `Canvas` with `draw*` methods.

```php
$canvas->drawText('Basic Usage', 300, 20, 32, valign: 'top');
```

You can save the image into a file with `save` method.

```php
$canvas
    ->drawText('Basic Usage', 300, 20, 32, valign: 'top')
    ->save('img/BasicUsage.png');
```

Available methods to draw on the `Canvas`:

- `fill()`: fills the `Canvas` with the specified color.
    |params|type|required|default|exampl|description|
    |:---|:---|:---|:---:|:---:|:---|
    |$x|int|required||10|horizontal position (in pixel)|
    |$y|int|required||20|vertical position (in pixel)|
    |$color|string|required||'#0000ff'|color code (in hex format)|

- `drawPixel()`: draws a pixel.
    |params|type|required|default|exampl|description|
    |:---|:---|:---|:---:|:---:|:---|
    |$x|int|required||10|horizontal position (in pixel)|
    |$y|int|required||20|vertical position (in pixel)|
    |$color|string|required||'#0000ff'|color code (in hex format)|

- `drawLine()`: draws a line.
    |params|type|required|default|exampl|description|
    |:---|:---|:---|:---:|:---:|:---|
    |$x1|int|required||10|horizontal position of starting point (in pixel)|
    |$y1|int|required||20|vertical position of starting point (in pixel)|
    |$x2|int|required||30|horizontal position of end point (in pixel)|
    |$y2|int|required||40|vertical position of end point (in pixel)|
    |$width|int||1|2|vertical position (in pixel)|
    |$color|string||'#000000'|'#0000ff'|color code (in hex format)|
    |$dash|int[]||[]|[8, 4, 2, 4]|dash pattern(solid and blank)|

- `drawBox()`:
    |params|type|required|default|exampl|description|
    |:---|:---|:---|:---:|:---:|:---|
    |$x1|int|required||10|horizontal position of starting point (in pixel)|
    |$y1|int|required||20|vertical position of starting point (in pixel)|
    |$x2|int|required||30|horizontal position of end point (in pixel)|
    |$y2|int|required||40|vertical position of end point (in pixel)|
    |$backgroundColor|string\|null||`null`|'#ccffff'|background color (in hex format)|
    |$borderWidth|int||1|2|border width (in pixel)|
    |$borderColor|string\|null||'#000000'|'#0000ff'|border color (in hex format)|

- `drawCircle()`:
- `drawEllipse()`:
- `drawPolygon()`:
- `drawBezier()`:
- `drawText()`:

### 5-2. Adjusting plot area

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Macocci7\PhpPlotter2d\Plotter;

$plotter = Plotter::make(
    canvasSize: [
        'width' => 800,     // required
        'height' => 400,    // required
    ],
    viewport: [
        'x' => [-5, 5],     // required
        'y' => [-5, 5],     // required
    ],
    plotarea: [ // optional
        // 20pix from left edge, 30pix from top edge
        // default=(10% of the canvas)
        'offset' => [20, 30],
        'width' => 640, // in pix, default=(80% of the canvas)
        'height' => 360 // in pix, default=(80% of the canvas)
    ],
    backgroundColor: '#0000cc',  // optional, default='#ffffff'
);
```

### 5-3. Adjusting

## 6. Exampoles

## 7. LICENSE

***

*Copyright 2024 macocci7*
